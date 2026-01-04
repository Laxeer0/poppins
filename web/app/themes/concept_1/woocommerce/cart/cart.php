<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <div class="overflow-x-auto">
        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents pop-table" cellspacing="0">
            <thead>
            <tr>
                <th class="product-remove"></th>
                <th class="product-thumbnail"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <tr class="woocommerce-cart-form__cart-item" <?php echo wc_get_cart_item_class('', $cart_item, $cart_item_key); ?>>
                        <td class="product-remove">
                            <?php
                            echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove text-[#FF2030]" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($_product->get_sku())
                            ), $cart_item_key);
                            ?>
                        </td>

                        <td class="product-thumbnail">
                            <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('popbag-card'), $cart_item, $cart_item_key);
                            if (!$product_permalink) {
                                echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput
                            } else {
                                printf('<a href="%s" class="block rounded-xl border-4 border-[#003745] p-1 shadow-[4px_4px_0_#003745]">%s</a>', esc_url($product_permalink), $thumbnail);
                            }
                            ?>
                        </td>

                        <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                            <?php
                            if (!$product_permalink) {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                            } else {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a class="font-black text-[#003745]" href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                            }
                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                            echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput

                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="text-xs font-bold uppercase text-[#FF2030]">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                            }
                            ?>
                        </td>

                        <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php echo apply_filters('woocommerce_cart_item_price', wc_price($_product->get_price()), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </td>

                        <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input([
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                    'min_value'    => '0',
                                    'product_name' => $_product->get_name(),
                                ], $_product, false);
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput
                            ?>
                        </td>

                        <td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <tr>
                <td colspan="5" class="actions">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <?php if (wc_coupons_enabled()) : ?>
                            <div class="coupon flex flex-col gap-2 md:flex-row md:items-center">
                                <label for="coupon_code" class="pop-label"><?php esc_html_e('Coupon', 'woocommerce'); ?></label>
                                <input type="text" name="coupon_code" class="input-text pop-input w-full md:w-64" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                                <button type="submit" class="btn-secondary" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                                <?php do_action('woocommerce_cart_coupon'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-wrap gap-3">
                            <button type="submit" class="btn-secondary" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
                            <a class="btn-primary" href="<?php echo esc_url(wc_get_checkout_url()); ?>"><?php esc_html_e('Checkout', 'woocommerce'); ?></a>
                            <?php do_action('woocommerce_proceed_to_checkout'); ?>
                        </div>
                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    </div>
                </td>
            </tr>

            <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>
        </table>
    </div>
</form>

<div class="cart-collaterals mt-8">
    <?php do_action('woocommerce_cart_collaterals'); ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>

