<?php
/**
 * Review order table.
 */
defined('ABSPATH') || exit;
?>

<table class="w-full text-sm">
	<thead class="text-left uppercase tracking-[0.12em] text-[#1F525E]">
		<tr>
			<th class="py-3 font-semibold"><?php esc_html_e('Product', 'woocommerce'); ?></th>
			<th class="py-3 text-right font-semibold"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
		</tr>
	</thead>
	<tbody class="border-t border-[#003745]/10">
		<?php do_action('woocommerce_review_order_before_cart_contents'); ?>

		<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
			<?php
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
			if (!$_product || !$cart_item['quantity']) {
				continue;
			}
			?>
			<tr class="border-b border-[#003745]/10">
				<td class="py-3">
					<div class="font-semibold text-[#003745]">
						<?php echo wp_kses_post($_product->get_name()); ?>
						<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', '<strong class="product-quantity"> × ' . absint($cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="text-[#1F525E]">
						<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</td>
				<td class="py-3 text-right font-semibold text-[#003745]">
					<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</td>
			</tr>
		<?php endforeach; ?>

		<?php do_action('woocommerce_review_order_after_cart_contents'); ?>
	</tbody>
	<tfoot class="border-t border-[#003745]/10">
		<tr class="cart-subtotal">
			<th class="py-3 text-left font-semibold text-[#1F525E]"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
			<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
				<th class="py-3 text-left font-semibold text-[#1F525E]"><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php wc_cart_totals_shipping_html(); ?>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<tr class="fee">
				<th class="py-3 text-left font-semibold text-[#1F525E]"><?php echo esc_html($fee->name); ?></th>
				<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_fee_html($fee); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
			<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
				<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
						<th class="py-3 text-left font-semibold text-[#1F525E]"><?php echo esc_html($tax->label); ?></th>
						<td class="py-3 text-right font-semibold text-[#003745]"><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th class="py-3 text-left font-semibold text-[#1F525E]"><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
					<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<tr class="order-total">
			<th class="py-4 text-left text-base font-black text-[#003745]"><?php esc_html_e('Total', 'woocommerce'); ?></th>
			<td class="py-4 text-right text-base font-black text-[#003745]"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>
	</tfoot>
</table>



