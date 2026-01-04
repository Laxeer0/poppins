<?php
/**
 * Theme bootstrap for Popbag Editorial Lookbook.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme supports & menus.
 */
function popbag_setup_theme() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    register_nav_menus([
        'primary' => __('Primary Menu', 'popbag-editorial'),
        'footer'  => __('Footer Menu', 'popbag-editorial'),
    ]);
}
add_action('after_setup_theme', 'popbag_setup_theme');

/**
 * Asset enqueue.
 */
function popbag_enqueue_assets() {
    $theme_dir = get_template_directory_uri();
    $asset_path = get_template_directory() . '/dist/app.css';
    $ver = file_exists($asset_path) ? filemtime($asset_path) : wp_get_theme()->get('Version');
    wp_enqueue_style('popbag-app', $theme_dir . '/dist/app.css', [], $ver);
}
add_action('wp_enqueue_scripts', 'popbag_enqueue_assets');

/**
 * Cache helpers.
 */
function popbag_cache_key($key) {
    $version = (int) get_option('popbag_cache_v', 1);
    return 'popbag_' . $version . '_' . $key;
}

function popbag_cache_get($key, $ttl, callable $callback) {
    $t_key = popbag_cache_key($key);
    $cached = get_transient($t_key);
    if (false !== $cached) {
        return $cached;
    }
    $value = call_user_func($callback);
    set_transient($t_key, $value, $ttl);
    return $value;
}

function popbag_cache_bump() {
    $version = (int) get_option('popbag_cache_v', 1);
    update_option('popbag_cache_v', $version + 1);
}

add_action('save_post_product', 'popbag_cache_bump');
add_action('deleted_post', 'popbag_cache_bump');
add_action('transition_post_status', 'popbag_cache_bump', 10, 3);
add_action('woocommerce_update_product', 'popbag_cache_bump');
add_action('woocommerce_product_set_stock', 'popbag_cache_bump');
add_action('created_term', 'popbag_cache_bump', 10, 3);
add_action('edited_terms', 'popbag_cache_bump', 10, 3);
add_action('delete_term', 'popbag_cache_bump', 10, 3);

/**
 * Data helpers.
 */
function popbag_mock_stories() {
    $placeholder = popbag_placeholder_img();
    return [
        [
            'title'   => __('Chromatic Rush', 'popbag-editorial'),
            'excerpt' => __('A bold mix of neon reds and deep teal for winter layers.', 'popbag-editorial'),
            'image'   => $placeholder,
            'link'    => '/lookbook',
            'label'   => '01',
        ],
        [
            'title'   => __('Midnight Studio', 'popbag-editorial'),
            'excerpt' => __('Tailored silhouettes with glossy finishes for after-dark looks.', 'popbag-editorial'),
            'image'   => $placeholder,
            'link'    => '/lookbook',
            'label'   => '02',
        ],
        [
            'title'   => __('Soft Armour', 'popbag-editorial'),
            'excerpt' => __('Padded volumes and capsule badges for daily armor.', 'popbag-editorial'),
            'image'   => $placeholder,
            'link'    => '/lookbook',
            'label'   => '03',
        ],
    ];
}

function popbag_get_products_cached($key, $ttl, $query_args) {
    return popbag_cache_get($key, $ttl, function () use ($query_args) {
        return wc_get_products($query_args);
    });
}

/**
 * Render product card reusable snippet.
 */
function popbag_render_product_card($product, $badge = '') {
    if (!$product) {
        return;
    }
    $permalink = $product->get_permalink();
    $title     = $product->get_name();
    $price_html = $product->get_price_html();
    $image = $product->get_image('woocommerce_thumbnail', ['class' => 'w-full h-full object-cover']);
    ?>
    <div class="group relative flex flex-col border-4 border-[#003745] rounded-[20px] bg-white shadow-[8px_8px_0_0_rgba(0,55,69,0.3)] transition-transform duration-150 ease-out hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[12px_12px_0_0_rgba(0,55,69,0.35)]">
        <a href="<?php echo esc_url($permalink); ?>" class="block aspect-[4/5] overflow-hidden rounded-t-[16px] bg-[#F9E2B0]">
            <?php echo $image; ?>
        </a>
        <div class="flex-1 flex flex-col gap-2 p-4">
            <div class="flex items-start justify-between gap-2">
                <h3 class="font-black text-lg text-[#003745] leading-tight"><?php echo esc_html($title); ?></h3>
                <?php if ($badge) : ?>
                    <span class="shrink-0 px-3 py-1 text-[10px] tracking-[0.1em] uppercase bg-[#FF2030] text-white rounded-full font-black"><?php echo esc_html($badge); ?></span>
                <?php endif; ?>
            </div>
            <div class="text-[#770417] font-semibold text-base"><?php echo wp_kses_post($price_html); ?></div>
            <div class="mt-auto">
                <a href="<?php echo esc_url($permalink); ?>" class="inline-flex items-center justify-center px-4 py-2 bg-[#003745] text-white uppercase tracking-[0.08em] text-xs font-black rounded-full hover:bg-[#1F525E] transition-colors">
                    <?php esc_html_e('View', 'popbag-editorial'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Utility: get placeholder if no image assets shipped.
 */
function popbag_placeholder_img() {
    return 'https://via.placeholder.com/1200x1600/FF2030/FFFFFF?text=POP+BAG';
}

