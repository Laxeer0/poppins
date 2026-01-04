<?php
defined('ABSPATH') || exit;

get_header('shop');
?>

<section class="bg-[#F9E2B0] border-b-4 border-[#003745]">
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-2">
        <div class="text-sm uppercase tracking-[0.1em] font-black">POP BAG — Shop</div>
        <h1 class="text-[48px] leading-none font-black text-[#003745]"><?php woocommerce_page_title(); ?></h1>
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <p class="text-sm text-[#1F525E]">Editorial POP grid. Hard edges, bold badges.</p>
        <?php endif; ?>
    </div>
</section>

<section class="bg-white py-10">
    <div class="max-w-6xl mx-auto px-6">
        <?php if (woocommerce_product_loop()) : ?>
            <?php do_action('woocommerce_before_shop_loop'); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while (have_posts()) : the_post(); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; ?>
            </div>
            <?php do_action('woocommerce_after_shop_loop'); ?>
        <?php else : ?>
            <?php do_action('woocommerce_no_products_found'); ?>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer('shop');

