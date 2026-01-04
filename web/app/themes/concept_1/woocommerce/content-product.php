<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$badges = function_exists('popbag_get_product_badges') ? popbag_get_product_badges($product) : [];
?>
<div <?php wc_product_class('pop-card pop-card-hover relative flex h-full flex-col overflow-hidden bg-white', $product); ?>>
    <div class="relative">
        <div class="absolute left-3 top-3 flex flex-col gap-2">
            <?php foreach ($badges as $badge) : ?>
                <?php
                $class = 'badge badge-new';
                if ('DROP' === $badge) {
                    $class = 'badge badge-drop';
                } elseif ('LIMITED' === $badge) {
                    $class = 'badge badge-limited';
                }
                ?>
                <span class="<?php echo esc_attr($class); ?>"><?php echo esc_html($badge); ?></span>
            <?php endforeach; ?>
            <?php woocommerce_show_product_sale_flash(); ?>
        </div>
        <?php do_action('woocommerce_before_shop_loop_item'); ?>
        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
    </div>
    <div class="flex flex-1 flex-col gap-2 px-4 pb-4 pt-3">
        <?php do_action('woocommerce_shop_loop_item_title'); ?>
        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
        <div class="mt-auto pt-3">
            <?php do_action('woocommerce_after_shop_loop_item'); ?>
        </div>
    </div>
</div>

