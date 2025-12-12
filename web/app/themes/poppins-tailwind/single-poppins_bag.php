<?php
/**
 * Template per la singola Bag.
 *
 * @package PoppinsTailwind
 */

get_header();
?>

<main class="mx-auto flex w-full max-w-6xl flex-col gap-16 px-6 py-16">
    <?php
    while (have_posts()) :
        the_post();
        $bag_id   = get_the_ID();
        $slug     = get_post_meta($bag_id, '_poppins_bag_slug', true);
        $capacity = (int) get_post_meta($bag_id, '_poppins_bag_capacity', true);
        $limits   = $slug ? poppins_get_bag_category_limits($slug) : [];
        $products = poppins_get_products_for_bag_post($bag_id);
        ?>
        <section class="text-center">
            <p class="text-xs uppercase tracking-[0.5em] text-stone-500"><?php esc_html_e('Bag Poppins', 'poppins'); ?></p>
            <h1 class="mt-4 text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl"><?php the_title(); ?></h1>
            <p class="mt-3 text-sm uppercase tracking-[0.4em] text-stone-500">
                <?php
                printf(
                    /* translators: %d Numero capi */
                    esc_html__('Fino a %d capi', 'poppins'),
                    max(1, $capacity),
                );
        ?>
            </p>
            <div class="mx-auto mt-6 max-w-3xl text-lg text-stone-600">
                <?php the_content(); ?>
            </div>
        </section>

        <?php if ($limits) : ?>
            <section class="rounded-[32px] bg-white p-10 shadow-2xl shadow-stone-200">
                <h2 class="text-2xl font-semibold text-stone-900"><?php esc_html_e('Limiti per categoria', 'poppins'); ?></h2>
                <p class="mt-2 text-stone-600"><?php esc_html_e('Quanti capi puoi scegliere per ogni categoria.', 'poppins'); ?></p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <?php foreach ($limits as $term_id => $limit) :
                        $term = get_term($term_id, 'product_cat');
                        if (!$term || is_wp_error($term)) {
                            continue;
                        }
                        ?>
                        <div class="rounded-3xl border border-stone-200 bg-stone-50 p-5 text-left">
                            <p class="text-sm uppercase tracking-[0.3em] text-stone-500"><?php echo esc_html($term->name); ?></p>
                            <p class="text-2xl font-semibold text-stone-900">
                                <?php
                                printf(
                                    /* translators: %d numero capi */
                                    esc_html__('%d capi', 'poppins'),
                                    absint($limit),
                                );
                        ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.5em] text-stone-500"><?php esc_html_e('Selezione curata', 'poppins'); ?></p>
                    <h2 class="mt-2 text-3xl font-semibold text-stone-900"><?php esc_html_e('Prodotti inclusi', 'poppins'); ?></h2>
                </div>
                <a class="text-xs font-semibold uppercase tracking-[0.3em] text-stone-500 hover:text-stone-900" href="<?php echo esc_url(home_url('/shop')); ?>">
                    <?php esc_html_e('Vai allo shop', 'poppins'); ?>
                </a>
            </div>

            <?php if (!$products) : ?>
                <p class="mt-6 text-stone-600"><?php esc_html_e('Nessun prodotto è ancora stato associato a questa bag.', 'poppins'); ?></p>
            <?php else : ?>
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($products as $product_id) :
                        $product = wc_get_product($product_id);
                        if (!$product) {
                            continue;
                        }
                        ?>
                        <article class="rounded-[28px] border border-stone-200 bg-white p-5 shadow-lg shadow-stone-200 transition hover:-translate-y-1">
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="block overflow-hidden rounded-2xl bg-stone-100">
                                <?php echo $product->get_image('medium'); ?>
                            </a>
                            <div class="mt-4">
                                <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="text-lg font-semibold text-stone-900">
                                    <?php echo esc_html($product->get_name()); ?>
                                </a>
                                <p class="mt-1 text-stone-600"><?php echo $product->get_price_html(); ?></p>
                                <a class="btn btn-outline mt-3 inline-flex px-4 py-2" href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                    <?php esc_html_e('Dettagli', 'poppins'); ?>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    <?php endwhile; ?>
</main>

<?php
get_footer();
