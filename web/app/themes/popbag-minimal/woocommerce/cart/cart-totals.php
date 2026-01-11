<?php
/**
 * Cart totals.
 */
defined('ABSPATH') || exit;
?>

<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Cart totals', 'woocommerce'); ?></h2>

	<table cellspacing="0" class="mt-6 w-full text-sm">
		<tbody>
			<tr class="border-t border-[#003745]/10 cart-subtotal">
				<th class="py-3 text-left font-semibold text-[#1F525E]"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
				<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>

			<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
				<tr class="border-t border-[#003745]/10 cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
					<th class="py-3 text-left font-semibold text-[#1F525E]"><?php wc_cart_totals_coupon_label($coupon); ?></th>
					<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_coupon_html($coupon); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
				<?php do_action('woocommerce_cart_totals_before_shipping'); ?>
				<?php wc_cart_totals_shipping_html(); ?>
				<?php do_action('woocommerce_cart_totals_after_shipping'); ?>
			<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>
				<tr class="border-t border-[#003745]/10 shipping">
					<th class="py-3 text-left font-semibold text-[#1F525E]"><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
					<td class="py-3 text-right"><?php woocommerce_shipping_calculator(); ?></td>
				</tr>
			<?php endif; ?>

			<?php foreach (WC()->cart->get_fees() as $fee) : ?>
				<tr class="border-t border-[#003745]/10 fee">
					<th class="py-3 text-left font-semibold text-[#1F525E]"><?php echo esc_html($fee->name); ?></th>
					<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_fee_html($fee); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
				<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
					<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
						<tr class="border-t border-[#003745]/10 tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
							<th class="py-3 text-left font-semibold text-[#1F525E]"><?php echo esc_html($tax->label); ?></th>
							<td class="py-3 text-right font-semibold text-[#003745]"><?php echo wp_kses_post($tax->formatted_amount); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr class="border-t border-[#003745]/10 tax-total">
						<th class="py-3 text-left font-semibold text-[#1F525E]"><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
						<td class="py-3 text-right font-semibold text-[#003745]"><?php wc_cart_totals_taxes_total_html(); ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>

			<tr class="border-t border-[#003745]/10 order-total">
				<th class="py-4 text-left text-base font-black text-[#003745]"><?php esc_html_e('Total', 'woocommerce'); ?></th>
				<td class="py-4 text-right text-base font-black text-[#003745]"><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
		</tbody>
	</table>

	<div class="mt-6">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>
</div>



