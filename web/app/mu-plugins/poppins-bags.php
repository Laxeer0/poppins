<?php

/**
 * Gestione dinamica delle bag (creazione da dashboard + assegnazione prodotti).
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Disabilita Gutenberg (block editor) per il post type delle bag.
 */
add_filter(
    'use_block_editor_for_post_type',
    static function (bool $use_block_editor, string $post_type): bool {
        if ($post_type === 'poppins_bag') {
            return false;
        }

        return $use_block_editor;
    },
    10,
    2,
);

/**
 * Registra il Custom Post Type "Bag".
 */
add_action(
    'init',
    static function (): void {
        $labels = [
            'name'               => __('Bag', 'poppins'),
            'singular_name'      => __('Bag', 'poppins'),
            'add_new'            => __('Aggiungi bag', 'poppins'),
            'add_new_item'       => __('Nuova bag', 'poppins'),
            'edit_item'          => __('Modifica bag', 'poppins'),
            'new_item'           => __('Nuova bag', 'poppins'),
            'view_item'          => __('Vedi bag', 'poppins'),
            'search_items'       => __('Cerca bag', 'poppins'),
            'not_found'          => __('Nessuna bag trovata', 'poppins'),
            'menu_name'          => __('Bag', 'poppins'),
        ];

        register_post_type(
            'poppins_bag',
            [
                'labels'        => $labels,
                'public'        => true,
                'show_ui'       => true,
                'show_in_menu'  => true,
                'has_archive'   => true,
                'rewrite'       => [
                    'slug'       => 'bags',
                    'with_front' => false,
                ],
                'capability_type' => 'post',
                'supports'      => ['title', 'editor', 'excerpt', 'thumbnail'],
                'menu_icon'     => 'dashicons-shopping-bag',
                'menu_position' => 25,
                'show_in_rest'  => true,
            ],
        );
    },
);

/**
 * Aggiunge le meta box per capienza e slug.
 */
add_action(
    'add_meta_boxes',
    static function (): void {
        add_meta_box(
            'poppins_bag_details',
            __('Dettagli bag', 'poppins'),
            function (WP_Post $post): void {
                $capacity        = (int) get_post_meta($post->ID, '_poppins_bag_capacity', true);
                $slug            = get_post_meta($post->ID, '_poppins_bag_slug', true);
                $price           = (string) get_post_meta($post->ID, '_poppins_bag_price', true);
                $category_limits = (array) get_post_meta($post->ID, '_poppins_bag_category_limits', true);
                $category_or_pairs = (array) get_post_meta($post->ID, '_poppins_bag_category_or_pairs', true);
                $modes = (array) get_post_meta($post->ID, '_poppins_bag_selection_modes', true);
                $categories      = get_terms(
                    [
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                    ],
                );
                wp_nonce_field('poppins_save_bag_details', 'poppins_bag_nonce');
                ?>
                <p>
                    <label for="poppins_bag_slug"><?php esc_html_e('Identificativo unico (es. bag_l)', 'poppins'); ?></label><br>
                    <input type="text" id="poppins_bag_slug" name="poppins_bag_slug" value="<?php echo esc_attr($slug); ?>" class="regular-text" required>
                </p>
                <p>
                    <label for="poppins_bag_capacity"><?php esc_html_e('Capienza massima (numero prodotti)', 'poppins'); ?></label><br>
                    <input type="number" min="1" id="poppins_bag_capacity" name="poppins_bag_capacity" value="<?php echo esc_attr($capacity ?: 1); ?>">
                </p>
                <p>
                    <label for="poppins_bag_price"><?php esc_html_e('Prezzo bag', 'poppins'); ?></label><br>
                    <input type="number" min="0" step="0.01" id="poppins_bag_price" name="poppins_bag_price" value="<?php echo esc_attr($price); ?>" class="regular-text">
                </p>
                <?php if ($categories && !is_wp_error($categories)) : ?>
                    <hr>
                    <p><strong><?php esc_html_e('Limiti per categoria', 'poppins'); ?></strong></p>
                    <p class="description"><?php esc_html_e('Imposta il numero massimo di capi consentiti per ciascuna categoria nella bag. Lascia vuoto o 0 per nessun limite.', 'poppins'); ?></p>
                    <table class="widefat striped" style="max-width:640px;">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Categoria', 'poppins'); ?></th>
                                <th width="120"><?php esc_html_e('Max capi', 'poppins'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category) : ?>
                                <tr>
                                    <td><?php echo esc_html($category->name); ?></td>
                                    <td>
                                        <input type="number" min="0" name="poppins_bag_category_limits[<?php echo esc_attr($category->term_id); ?>]" value="<?php echo esc_attr($category_limits[$category->term_id] ?? ''); ?>" style="width:100%;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <hr>
                    <p><strong><?php esc_html_e('Opzioni OR tra categorie', 'poppins'); ?></strong></p>
                    <p class="description"><?php esc_html_e('Configura coppie di categorie mutuamente esclusive: nella selezione prodotti la bag permetterà di scegliere al massimo 1 capo totale tra le 2 categorie (A OR B).', 'poppins'); ?></p>
                    <table class="widefat striped" style="max-width:640px;" id="poppins-bag-or-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Categoria A', 'poppins'); ?></th>
                                <th><?php esc_html_e('Categoria B', 'poppins'); ?></th>
                                <th width="60"><?php esc_html_e('Azioni', 'poppins'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rows = [];
                            foreach ($category_or_pairs as $row) {
                                if (!is_array($row)) {
                                    continue;
                                }
                                $a = isset($row['a']) ? (int) $row['a'] : (isset($row[0]) ? (int) $row[0] : 0);
                                $b = isset($row['b']) ? (int) $row['b'] : (isset($row[1]) ? (int) $row[1] : 0);
                                $a = (int) $a;
                                $b = (int) $b;
                                if ($a > 0 && $b > 0 && $a !== $b) {
                                    $rows[] = ['a' => $a, 'b' => $b];
                                }
                            }
                            if (!$rows) {
                                $rows[] = ['a' => 0, 'b' => 0];
                            }
                            $render_select = static function (string $name, int $selected_id) use ($categories): void {
                                ?>
                                <select name="<?php echo esc_attr($name); ?>" style="width:100%;">
                                    <option value=""><?php esc_html_e('— Seleziona —', 'poppins'); ?></option>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?php echo esc_attr((string) $cat->term_id); ?>" <?php selected((int) $selected_id, (int) $cat->term_id); ?>>
                                            <?php echo esc_html($cat->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php
                            };
                            ?>

                            <?php foreach ($rows as $i => $row) : ?>
                                <tr class="poppins-bag-or-row">
                                    <td>
                                        <?php $render_select('poppins_bag_category_or_pairs[' . (int) $i . '][a]', (int) ($row['a'] ?? 0)); ?>
                                    </td>
                                    <td>
                                        <?php $render_select('poppins_bag_category_or_pairs[' . (int) $i . '][b]', (int) ($row['b'] ?? 0)); ?>
                                    </td>
                                    <td>
                                        <button type="button" class="button poppins-bag-or-remove"><?php esc_html_e('Rimuovi', 'poppins'); ?></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p style="margin-top:10px;">
                        <button type="button" class="button button-secondary" id="poppins-bag-or-add"><?php esc_html_e('Aggiungi regola OR', 'poppins'); ?></button>
                    </p>

                    <script>
                        (function () {
                            const table = document.getElementById('poppins-bag-or-table');
                            const addBtn = document.getElementById('poppins-bag-or-add');
                            if (!table || !addBtn) return;

                            const wireRow = (row) => {
                                const remove = row.querySelector('.poppins-bag-or-remove');
                                if (!remove) return;
                                remove.addEventListener('click', () => {
                                    const tbody = table.querySelector('tbody');
                                    if (!tbody) return;
                                    row.remove();
                                    // ensure at least one row exists
                                    if (!tbody.querySelector('.poppins-bag-or-row')) {
                                        addBtn.click();
                                    }
                                });
                            };

                            table.querySelectorAll('.poppins-bag-or-row').forEach(wireRow);

                            addBtn.addEventListener('click', () => {
                                const tbody = table.querySelector('tbody');
                                if (!tbody) return;
                                const idx = tbody.querySelectorAll('.poppins-bag-or-row').length;
                                const first = tbody.querySelector('.poppins-bag-or-row');
                                if (!first) return;
                                const clone = first.cloneNode(true);
                                clone.querySelectorAll('select').forEach((sel) => {
                                    // reset selection
                                    sel.value = '';
                                    // rewrite name with new index
                                    sel.name = sel.name.replace(/poppins_bag_category_or_pairs\[\d+\]/, `poppins_bag_category_or_pairs[${idx}]`);
                                });
                                tbody.appendChild(clone);
                                wireRow(clone);
                            });
                        })();
                    </script>

                    <hr>
                    <p><strong><?php esc_html_e('Modalità di selezione (avanzate)', 'poppins'); ?></strong></p>
                    <p class="description">
                        <?php esc_html_e('Se configurate, le modalità sostituiscono “Capienza”/limiti e permettono regole tipo: Outfit completo (1 tra jeans/pantaloni + 1 tra felpa/maglia + 1 giubbotto) oppure Vintage (5 capi a scelta tra jeans/felpe).', 'poppins'); ?>
                    </p>

                    <?php
                    $modes_rows = [];
                    foreach ($modes as $mode) {
                        if (!is_array($mode)) {
                            continue;
                        }
                        $label = sanitize_text_field((string) ($mode['label'] ?? ''));
                        $min_items = isset($mode['min_items']) ? (int) $mode['min_items'] : 1;
                        $max_items = isset($mode['max_items']) ? (int) $mode['max_items'] : 0;
                        $groups = isset($mode['groups']) && is_array($mode['groups']) ? $mode['groups'] : [];
                        if ($label === '' || $max_items <= 0) {
                            continue;
                        }
                        $g_rows = [];
                        foreach ($groups as $g) {
                            if (!is_array($g)) {
                                continue;
                            }
                            $cats = isset($g['cats']) && is_array($g['cats']) ? array_values(array_filter(array_map('absint', $g['cats']))) : [];
                            $gmin = isset($g['min']) ? absint($g['min']) : 0;
                            $gmax = isset($g['max']) ? absint($g['max']) : 0;
                            if (!$cats || $gmax <= 0) {
                                continue;
                            }
                            if ($gmin > $gmax) {
                                $gmin = $gmax;
                            }
                            $g_rows[] = ['cats' => $cats, 'min' => $gmin, 'max' => $gmax];
                        }
                        if (!$g_rows) {
                            continue;
                        }
                        $modes_rows[] = [
                            'label' => $label,
                            'min_items' => max(0, $min_items),
                            'max_items' => max(1, $max_items),
                            'groups' => $g_rows,
                        ];
                    }

                    if (!$modes_rows) {
                        $modes_rows[] = [
                            'label' => __('Outfit completo', 'poppins'),
                            'min_items' => 3,
                            'max_items' => 3,
                            'groups' => [
                                ['cats' => [], 'min' => 1, 'max' => 1],
                            ],
                        ];
                    }

                    $render_multiselect = static function (string $name, array $selected_ids, array $categories): void {
                        ?>
                        <select name="<?php echo esc_attr($name); ?>[]" multiple size="6" style="width:100%; max-width: 340px;">
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?php echo esc_attr((string) $cat->term_id); ?>" <?php selected(in_array((int) $cat->term_id, $selected_ids, true)); ?>>
                                    <?php echo esc_html($cat->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php
                    };
                    ?>

                    <div id="poppins-bag-modes">
                        <?php foreach ($modes_rows as $mi => $mode) : ?>
                            <div class="poppins-bag-mode" style="border:1px solid rgba(0,0,0,0.08); padding:12px; border-radius:10px; margin:12px 0; background:#fff;">
                                <div style="display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap;">
                                    <p style="margin:0;">
                                        <label><strong><?php esc_html_e('Nome modalità', 'poppins'); ?></strong></label><br>
                                        <input type="text" style="min-width:280px;" name="poppins_bag_modes[<?php echo (int) $mi; ?>][label]" value="<?php echo esc_attr((string) ($mode['label'] ?? '')); ?>" class="regular-text">
                                    </p>
                                    <p style="margin:0;">
                                        <label><strong><?php esc_html_e('Min capi (totale)', 'poppins'); ?></strong></label><br>
                                        <input type="number" min="0" style="width:120px;" name="poppins_bag_modes[<?php echo (int) $mi; ?>][min_items]" value="<?php echo esc_attr((string) (int) ($mode['min_items'] ?? 0)); ?>">
                                    </p>
                                    <p style="margin:0;">
                                        <label><strong><?php esc_html_e('Max capi (totale)', 'poppins'); ?></strong></label><br>
                                        <input type="number" min="1" style="width:120px;" name="poppins_bag_modes[<?php echo (int) $mi; ?>][max_items]" value="<?php echo esc_attr((string) (int) ($mode['max_items'] ?? 1)); ?>">
                                    </p>
                                    <p style="margin:0;">
                                        <button type="button" class="button poppins-bag-mode-remove"><?php esc_html_e('Rimuovi modalità', 'poppins'); ?></button>
                                    </p>
                                </div>

                                <div style="margin-top:10px;">
                                    <p style="margin:0 0 6px;"><strong><?php esc_html_e('Gruppi (slot) di categoria', 'poppins'); ?></strong></p>
                                    <p class="description" style="margin-top:0;"><?php esc_html_e('Ogni gruppo conta quanti capi selezionati appartengono a UNA delle categorie selezionate. Esempio OR: min=1 max=1 con 2 categorie = “1 capo tra A oppure B”.', 'poppins'); ?></p>

                                    <table class="widefat striped poppins-bag-mode-groups" style="max-width:900px;">
                                        <thead>
                                            <tr>
                                                <th><?php esc_html_e('Categorie (una o più)', 'poppins'); ?></th>
                                                <th width="120"><?php esc_html_e('Min', 'poppins'); ?></th>
                                                <th width="120"><?php esc_html_e('Max', 'poppins'); ?></th>
                                                <th width="80"><?php esc_html_e('Azioni', 'poppins'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $groups = isset($mode['groups']) && is_array($mode['groups']) ? $mode['groups'] : [];
                                            if (!$groups) {
                                                $groups = [['cats' => [], 'min' => 1, 'max' => 1]];
                                            }
                                            ?>
                                            <?php foreach ($groups as $gi => $g) : ?>
                                                <tr class="poppins-bag-mode-group">
                                                    <td>
                                                        <?php
                                                        $sel = isset($g['cats']) && is_array($g['cats']) ? array_values(array_filter(array_map('absint', $g['cats']))) : [];
                                                        $render_multiselect('poppins_bag_modes[' . (int) $mi . '][groups][' . (int) $gi . '][cats]', $sel, $categories);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" style="width:100%;" name="poppins_bag_modes[<?php echo (int) $mi; ?>][groups][<?php echo (int) $gi; ?>][min]" value="<?php echo esc_attr((string) absint($g['min'] ?? 0)); ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" style="width:100%;" name="poppins_bag_modes[<?php echo (int) $mi; ?>][groups][<?php echo (int) $gi; ?>][max]" value="<?php echo esc_attr((string) absint($g['max'] ?? 0)); ?>">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="button poppins-bag-group-remove"><?php esc_html_e('Rimuovi', 'poppins'); ?></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <p style="margin-top:10px;">
                                        <button type="button" class="button button-secondary poppins-bag-group-add"><?php esc_html_e('Aggiungi gruppo', 'poppins'); ?></button>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <p style="margin-top:10px;">
                        <button type="button" class="button button-secondary" id="poppins-bag-mode-add"><?php esc_html_e('Aggiungi modalità', 'poppins'); ?></button>
                    </p>

                    <script>
                        (function () {
                            const wrapper = document.getElementById('poppins-bag-modes');
                            const addModeBtn = document.getElementById('poppins-bag-mode-add');
                            if (!wrapper || !addModeBtn) return;

                            const reindexNames = () => {
                                const modes = wrapper.querySelectorAll('.poppins-bag-mode');
                                modes.forEach((modeEl, mi) => {
                                    modeEl.querySelectorAll('input, select').forEach((el) => {
                                        const name = el.getAttribute('name');
                                        if (!name) return;
                                        // Replace first poppins_bag_modes[<n>]
                                        const newName = name.replace(/poppins_bag_modes\[\d+\]/, `poppins_bag_modes[${mi}]`);
                                        el.setAttribute('name', newName);
                                    });

                                    // Reindex groups within this mode
                                    const groups = modeEl.querySelectorAll('.poppins-bag-mode-group');
                                    groups.forEach((gEl, gi) => {
                                        gEl.querySelectorAll('input, select').forEach((el) => {
                                            const name = el.getAttribute('name');
                                            if (!name) return;
                                            const newName = name.replace(/groups\]\[\d+\]/, `groups][${gi}]`);
                                            el.setAttribute('name', newName);
                                        });
                                    });
                                });
                            };

                            const wireMode = (modeEl) => {
                                const removeBtn = modeEl.querySelector('.poppins-bag-mode-remove');
                                if (removeBtn) {
                                    removeBtn.addEventListener('click', () => {
                                        modeEl.remove();
                                        if (!wrapper.querySelector('.poppins-bag-mode')) {
                                            addModeBtn.click();
                                        }
                                        reindexNames();
                                    });
                                }

                                const addGroupBtn = modeEl.querySelector('.poppins-bag-group-add');
                                if (addGroupBtn) {
                                    addGroupBtn.addEventListener('click', () => {
                                        const tbody = modeEl.querySelector('table.poppins-bag-mode-groups tbody');
                                        if (!tbody) return;
                                        const first = tbody.querySelector('.poppins-bag-mode-group');
                                        if (!first) return;
                                        const clone = first.cloneNode(true);
                                        // reset
                                        clone.querySelectorAll('select').forEach((sel) => {
                                            Array.from(sel.options).forEach((opt) => (opt.selected = false));
                                        });
                                        clone.querySelectorAll('input[type="number"]').forEach((inp) => {
                                            if (inp.name && inp.name.endsWith('[min]')) inp.value = '0';
                                            if (inp.name && inp.name.endsWith('[max]')) inp.value = '1';
                                        });
                                        tbody.appendChild(clone);
                                        wireGroup(clone);
                                        reindexNames();
                                    });
                                }

                                modeEl.querySelectorAll('.poppins-bag-mode-group').forEach(wireGroup);
                            };

                            const wireGroup = (groupEl) => {
                                const remove = groupEl.querySelector('.poppins-bag-group-remove');
                                if (!remove) return;
                                remove.addEventListener('click', () => {
                                    const tbody = groupEl.closest('tbody');
                                    groupEl.remove();
                                    if (tbody && !tbody.querySelector('.poppins-bag-mode-group')) {
                                        // add one blank group by clicking add button in the mode
                                        const modeEl = tbody.closest('.poppins-bag-mode');
                                        const addBtn = modeEl ? modeEl.querySelector('.poppins-bag-group-add') : null;
                                        if (addBtn) addBtn.click();
                                    }
                                    reindexNames();
                                });
                            };

                            wrapper.querySelectorAll('.poppins-bag-mode').forEach(wireMode);

                            addModeBtn.addEventListener('click', () => {
                                const first = wrapper.querySelector('.poppins-bag-mode');
                                if (!first) return;
                                const clone = first.cloneNode(true);
                                // reset fields
                                clone.querySelectorAll('input[type="text"]').forEach((inp) => (inp.value = ''));
                                clone.querySelectorAll('input[type="number"]').forEach((inp) => {
                                    if (inp.name && inp.name.endsWith('[min_items]')) inp.value = '0';
                                    if (inp.name && inp.name.endsWith('[max_items]')) inp.value = '1';
                                    if (inp.name && inp.name.endsWith('[min]')) inp.value = '0';
                                    if (inp.name && inp.name.endsWith('[max]')) inp.value = '1';
                                });
                                clone.querySelectorAll('select').forEach((sel) => {
                                    Array.from(sel.options).forEach((opt) => (opt.selected = false));
                                });
                                // keep only 1 group row
                                const tbody = clone.querySelector('table.poppins-bag-mode-groups tbody');
                                if (tbody) {
                                    const rows = tbody.querySelectorAll('.poppins-bag-mode-group');
                                    rows.forEach((r, idx) => { if (idx > 0) r.remove(); });
                                }
                                wrapper.appendChild(clone);
                                wireMode(clone);
                                reindexNames();
                            });

                            reindexNames();
                        })();
                    </script>
                <?php endif; ?>
                <?php
            },
            'poppins_bag',
            'normal',
            'default',
        );
    },
);

/**
 * Salva le meta delle bag.
 */
add_action(
    'save_post_poppins_bag',
    static function (int $post_id, WP_Post $post): void {
        if (!isset($_POST['poppins_bag_nonce']) || !wp_verify_nonce($_POST['poppins_bag_nonce'], 'poppins_save_bag_details')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $slug     = sanitize_title($_POST['poppins_bag_slug'] ?? '');
        // Se non fornito (es. import/quick edit), genera uno slug stabile.
        if ($slug === '') {
            $slug = sanitize_title($post->post_title);
        }
        if ($slug === '') {
            $slug = 'bag-' . $post_id;
        }
        $capacity = max(1, (int) ($_POST['poppins_bag_capacity'] ?? 1));
        $raw_price = (string) ($_POST['poppins_bag_price'] ?? '');
        $raw_price = str_replace(',', '.', $raw_price);
        $price = max(0, (float) $raw_price);
        $limits   = [];
        $or_pairs = [];
        $modes    = [];

        if (!empty($_POST['poppins_bag_category_limits']) && is_array($_POST['poppins_bag_category_limits'])) {
            foreach ($_POST['poppins_bag_category_limits'] as $term_id => $value) {
                $term_id = (int) $term_id;
                $limit   = max(0, (int) $value);
                if ($term_id > 0 && $limit > 0) {
                    $limits[$term_id] = $limit;
                }
            }
        }

        if (!empty($_POST['poppins_bag_category_or_pairs']) && is_array($_POST['poppins_bag_category_or_pairs'])) {
            foreach ($_POST['poppins_bag_category_or_pairs'] as $row) {
                if (!is_array($row)) {
                    continue;
                }
                $a = isset($row['a']) ? (int) $row['a'] : 0;
                $b = isset($row['b']) ? (int) $row['b'] : 0;
                $a = (int) $a;
                $b = (int) $b;
                if ($a > 0 && $b > 0 && $a !== $b) {
                    $or_pairs[] = ['a' => $a, 'b' => $b];
                }
            }
        }

        if (!empty($_POST['poppins_bag_modes']) && is_array($_POST['poppins_bag_modes'])) {
            foreach ($_POST['poppins_bag_modes'] as $mode) {
                if (!is_array($mode)) {
                    continue;
                }
                $label = sanitize_text_field((string) ($mode['label'] ?? ''));
                $min_items = max(0, (int) ($mode['min_items'] ?? 0));
                $max_items = max(0, (int) ($mode['max_items'] ?? 0));
                if ($label === '' || $max_items <= 0) {
                    continue;
                }

                $groups_out = [];
                $groups = isset($mode['groups']) && is_array($mode['groups']) ? $mode['groups'] : [];
                foreach ($groups as $g) {
                    if (!is_array($g)) {
                        continue;
                    }
                    $cats = isset($g['cats']) && is_array($g['cats']) ? array_values(array_filter(array_map('absint', $g['cats']))) : [];
                    $gmin = max(0, (int) ($g['min'] ?? 0));
                    $gmax = max(0, (int) ($g['max'] ?? 0));
                    if (!$cats || $gmax <= 0) {
                        continue;
                    }
                    if ($gmin > $gmax) {
                        $gmin = $gmax;
                    }
                    $groups_out[] = [
                        'cats' => $cats,
                        'min'  => $gmin,
                        'max'  => $gmax,
                    ];
                }

                if (!$groups_out) {
                    continue;
                }

                $modes[] = [
                    'label'     => $label,
                    'min_items' => $min_items,
                    'max_items' => $max_items,
                    'groups'    => $groups_out,
                ];
            }
        }

        update_post_meta($post_id, '_poppins_bag_slug', $slug);
        update_post_meta($post_id, '_poppins_bag_capacity', $capacity);
        update_post_meta($post_id, '_poppins_bag_price', (string) $price);
        update_post_meta($post_id, '_poppins_bag_category_limits', $limits);
        update_post_meta($post_id, '_poppins_bag_category_or_pairs', $or_pairs);
        update_post_meta($post_id, '_poppins_bag_selection_modes', $modes);
    },
    10,
    2,
);

/**
 * Recupera tutte le bag.
 *
 * @return array<string, array{label: string, capacity: int, post_id: int, limits: array}>
 */
function poppins_get_bags(): array
{
    $query = new WP_Query(
        [
            'post_type'      => 'poppins_bag',
            'posts_per_page' => -1,
            // In admin vogliamo vedere anche bag non ancora pubblicate, altrimenti la lista risulta vuota.
            'post_status'    => is_admin() ? ['publish', 'private', 'draft', 'pending', 'future'] : 'publish',
            'orderby'        => 'title',
            'order'          => 'ASC',
            // Evita interferenze di filtri esterni (pre_get_posts/posts_clauses) sulla query.
            'suppress_filters' => true,
            'no_found_rows'    => true,
        ],
    );

    $bags = [];
    foreach ($query->posts as $bag_post) {
        $slug = (string) get_post_meta($bag_post->ID, '_poppins_bag_slug', true);
        // Fallback per bag create/importate senza meta: usa lo slug del post o un ID stabile.
        if ($slug === '') {
            $slug = (string) ($bag_post->post_name ?? '');
        }
        if ($slug === '') {
            $slug = 'bag-' . (int) $bag_post->ID;
        }

        $bags[$slug] = [
            'label'    => $bag_post->post_title,
            'capacity' => (int) get_post_meta($bag_post->ID, '_poppins_bag_capacity', true) ?: 1,
            'post_id'  => $bag_post->ID,
            'limits'   => (array) get_post_meta($bag_post->ID, '_poppins_bag_category_limits', true),
        ];
    }

    return $bags;
}

/**
 * Tab di selezione bag nei prodotti WooCommerce.
 */
add_filter(
    'woocommerce_product_data_tabs',
    static function (array $tabs): array {
        $tabs['poppins_bags'] = [
            'label'  => __('Bag selezionabili', 'poppins'),
            'target' => 'poppins_bags_product_data',
            'class'  => ['hide_if_grouped', 'hide_if_external'],
        ];

        return $tabs;
    },
);

add_action(
    'woocommerce_product_data_panels',
    static function (): void {
        global $post;

        $bags = poppins_get_bags();
        $selected = (array) get_post_meta($post->ID, '_poppins_bags_available', true);
        ?>
        <div id="poppins_bags_product_data" class="panel woocommerce_options_panel hidden">
            <div class="options_group">
                <p><?php esc_html_e('Rendi il prodotto disponibile nelle bag selezionate.', 'poppins'); ?></p>
                <?php if (!$bags) : ?>
                    <p><?php esc_html_e('Crea una bag dal menu “Bag” per iniziare.', 'poppins'); ?></p>
                <?php else : ?>
                    <p class="form-field poppins_bags_available_field">
                        <label><?php esc_html_e('Bag', 'poppins'); ?></label>
                        <span class="wrap" style="display:block;">
                            <?php foreach ($bags as $slug => $bag) : ?>
                                <label style="display:block; margin:0 0 6px;">
                                    <input type="checkbox" name="poppins_bags_available[]" value="<?php echo esc_attr($slug); ?>" <?php checked(in_array($slug, $selected, true)); ?>>
                                    <strong><?php echo esc_html($bag['label']); ?></strong>
                                    <small style="color:#777;">
                                        <?php
                                        printf(
                                            /* translators: %d: capacity */
                                            __('Capienza: %d prodotti', 'poppins'),
                                            absint($bag['capacity']),
                                        );
                                        ?>
                                    </small>
                                </label>
                            <?php endforeach; ?>
                        </span>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    },
);

add_action(
    'woocommerce_admin_process_product_object',
    static function ($product): void {
        $bags = array_map('sanitize_text_field', (array) ($_POST['poppins_bags_available'] ?? []));

        $available = [];
        foreach (poppins_get_bags() as $slug => $data) {
            if (in_array($slug, $bags, true)) {
                $available[] = $slug;
            }
        }

        $product->update_meta_data('_poppins_bags_available', $available);
    },
);

/**
 * Helpers pubblici.
 */
function poppins_product_is_available_for_bag(int $product_id, string $bag_slug): bool
{
    $available = (array) get_post_meta($product_id, '_poppins_bags_available', true);

    return in_array($bag_slug, $available, true);
}

function poppins_get_products_for_bag(string $bag_slug): array
{
    $query = new WP_Query(
        [
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'meta_query'     => [
                [
                    'key'     => '_poppins_bags_available',
                    'value'   => '"' . $bag_slug . '"',
                    'compare' => 'LIKE',
                ],
            ],
        ],
    );

    return $query->posts;
}

/**
 * Restituisce i prodotti associati a una bag partendo dall'ID post.
 *
 * @param int $bag_post_id
 * @return int[]
 */
function poppins_get_products_for_bag_post(int $bag_post_id): array
{
    $slug = get_post_meta($bag_post_id, '_poppins_bag_slug', true);
    if (!$slug) {
        return [];
    }

    return poppins_get_products_for_bag($slug);
}

/**
 * Restituisce i limiti per categoria per una bag.
 *
 * @return array<int, int>
 */
function poppins_get_bag_category_limits(string $bag_slug): array
{
    $bags = poppins_get_bags();
    if (!isset($bags[$bag_slug])) {
        return [];
    }

    return (array) ($bags[$bag_slug]['limits'] ?? []);
}
