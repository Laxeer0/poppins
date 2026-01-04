<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}
?>

<div <?php wc_product_class('popbag-card', $product); ?>>
    <?php popbag_render_product_card($product, __('New', 'popbag-editorial')); ?>
</div>

