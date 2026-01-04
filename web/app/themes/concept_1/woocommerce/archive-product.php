<?php
defined('ABSPATH') || exit;

get_header('shop');
?>
<?php do_action('woocommerce_before_main_content'); ?>
<div class="mx-auto max-w-6xl px-4 py-10">
    <header class="mb-6 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="text-4xl font-black text-[#003745]"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>
        <div class="flex flex-wrap gap-3">
            <?php do_action('woocommerce_archive_description'); ?>
        </div>
    </header>

    <?php if (woocommerce_product_loop()) : ?>
        <div class="mb-4 flex items-center justify-between gap-3">
            <?php do_action('woocommerce_before_shop_loop'); ?>
        </div>

        <?php woocommerce_product_loop_start(); ?>

        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <?php do_action('woocommerce_shop_loop'); ?>
            <?php wc_get_template_part('content', 'product'); ?>
        <?php endwhile; ?>

        <?php woocommerce_product_loop_end(); ?>

        <?php do_action('woocommerce_after_shop_loop'); ?>
    <?php else : ?>
        <?php do_action('woocommerce_no_products_found'); ?>
    <?php endif; ?>
</div>
<?php
do_action('woocommerce_after_main_content');
get_footer('shop');

