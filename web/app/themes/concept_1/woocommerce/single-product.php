<?php
defined('ABSPATH') || exit;

get_header('shop');
?>
<?php do_action('woocommerce_before_main_content'); ?>

<div class="mx-auto max-w-6xl px-4 py-10">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <div class="grid items-start gap-8 md:grid-cols-2">
            <div class="rounded-[20px] border-4 border-[#003745] bg-white p-4 shadow-[10px_10px_0_#003745]">
                <?php do_action('woocommerce_before_single_product_summary'); ?>
            </div>
            <div class="space-y-6 rounded-[20px] border-4 border-[#003745] bg-[#F9E2B0] p-6 shadow-[10px_10px_0_#003745]">
                <?php do_action('woocommerce_single_product_summary'); ?>
            </div>
        </div>
        <?php do_action('woocommerce_after_single_product_summary'); ?>
    <?php endwhile; ?>
</div>

<?php
do_action('woocommerce_after_main_content');
get_footer('shop');

