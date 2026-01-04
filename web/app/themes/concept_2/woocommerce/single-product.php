<?php
defined('ABSPATH') || exit;

get_header('shop');
global $product;
?>

<section class="bg-[#F9E2B0] border-b-4 border-[#003745]">
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-2">
        <div class="text-sm uppercase tracking-[0.1em] font-black">POP BAG — Product</div>
        <h1 class="text-[48px] leading-none font-black text-[#003745]"><?php the_title(); ?></h1>
    </div>
</section>

<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-10">
        <div class="border-4 border-[#003745] rounded-[20px] overflow-hidden shadow-[10px_10px_0_0_rgba(0,55,69,0.35)]">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>
        <div class="space-y-5">
            <div class="text-sm uppercase tracking-[0.08em] font-black bg-[#FF2030] text-white px-3 py-1 rounded-full inline-flex">Editors Pick</div>
            <div class="text-2xl font-black text-[#003745]"><?php woocommerce_template_single_price(); ?></div>
            <div class="text-base text-[#1F525E] leading-relaxed"><?php woocommerce_template_single_excerpt(); ?></div>
            <?php woocommerce_template_single_add_to_cart(); ?>
            <?php woocommerce_template_single_meta(); ?>
        </div>
    </div>
</section>

<section class="bg-[#F9E2B0] py-12">
    <div class="max-w-6xl mx-auto px-6">
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         */
        do_action('woocommerce_after_single_product_summary');
        ?>
    </div>
</section>

<?php
get_footer('shop');

