<?php
/**
 * View order.
 *
 * @var WC_Order $order
 */
defined('ABSPATH') || exit;

if (!isset($order) || !$order instanceof WC_Order) {
	return;
}

$order_status = wc_get_order_status_name($order->get_status());
?>

<div class="space-y-8">
	<div class="flex flex-wrap items-start justify-between gap-4">
		<div>
			<p class="text-sm uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Order', 'woocommerce'); ?></p>
			<h2 class="mt-1 text-xl font-black text-[#003745]">#<?php echo esc_html($order->get_order_number()); ?></h2>
			<p class="mt-2 text-sm text-[#1F525E]">
				<?php
				printf(
					/* translators: 1: status, 2: date */
					esc_html__('Status: %1$s · Placed on %2$s', 'popbag-minimal'),
					esc_html($order_status),
					esc_html(wc_format_datetime($order->get_date_created()))
				);
				?>
			</p>
		</div>

		<div class="flex flex-wrap gap-2">
			<a class="inline-flex items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:shadow-sm" href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>">
				<?php esc_html_e('Back to orders', 'woocommerce'); ?>
			</a>
		</div>
	</div>

	<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
		<h3 class="text-base font-black text-[#003745]"><?php esc_html_e('Items', 'woocommerce'); ?></h3>
		<div class="mt-4 divide-y divide-[#003745]/10">
			<?php foreach ($order->get_items() as $item_id => $item) :
				if (!$item instanceof WC_Order_Item_Product) {
					continue;
				}
				$product = $item->get_product();
				?>
				<div class="py-4">
					<div class="flex items-start justify-between gap-4">
						<div class="min-w-0">
							<p class="font-semibold text-[#003745]">
								<?php echo esc_html($item->get_name()); ?>
							</p>
							<p class="mt-1 text-sm text-[#1F525E]">
								<?php
								printf(
									/* translators: %d: quantity */
									esc_html__('Qty: %d', 'woocommerce'),
									absint($item->get_quantity())
								);
								?>
							</p>
							<?php
							$item_meta = wc_display_item_meta($item, ['echo' => false]);
							if ($item_meta) :
								?>
								<div class="mt-2 text-sm text-[#1F525E]">
									<?php echo wp_kses_post($item_meta); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="text-right text-sm font-semibold text-[#003745]">
							<?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="grid gap-6 lg:grid-cols-2">
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
			<h3 class="text-base font-black text-[#003745]"><?php esc_html_e('Totals', 'woocommerce'); ?></h3>
			<div class="mt-4 space-y-2 text-sm">
				<?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
					<div class="flex items-center justify-between gap-4">
						<span class="text-[#1F525E]"><?php echo esc_html($total['label']); ?></span>
						<span class="font-semibold text-[#003745]"><?php echo wp_kses_post($total['value']); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
			<h3 class="text-base font-black text-[#003745]"><?php esc_html_e('Addresses', 'woocommerce'); ?></h3>
			<div class="mt-4 grid gap-4 sm:grid-cols-2">
				<div class="rounded-[14px] border border-[#003745]/10 bg-[#003745]/5 p-4">
					<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Billing address', 'woocommerce'); ?></p>
					<div class="mt-2 text-sm text-[#003745]">
						<?php echo wp_kses_post($order->get_formatted_billing_address() ? $order->get_formatted_billing_address() : esc_html__('N/A', 'woocommerce')); ?>
					</div>
				</div>
				<div class="rounded-[14px] border border-[#003745]/10 bg-[#003745]/5 p-4">
					<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Shipping address', 'woocommerce'); ?></p>
					<div class="mt-2 text-sm text-[#003745]">
						<?php echo wp_kses_post($order->get_formatted_shipping_address() ? $order->get_formatted_shipping_address() : esc_html__('N/A', 'woocommerce')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if ($order->get_customer_note()) : ?>
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
			<h3 class="text-base font-black text-[#003745]"><?php esc_html_e('Customer note', 'woocommerce'); ?></h3>
			<p class="mt-3 text-sm text-[#1F525E]"><?php echo esc_html($order->get_customer_note()); ?></p>
		</div>
	<?php endif; ?>

	<?php do_action('woocommerce_view_order', $order->get_id()); ?>
</div>



