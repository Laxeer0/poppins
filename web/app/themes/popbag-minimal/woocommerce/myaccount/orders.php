<?php
/**
 * My Account orders.
 *
 * @var bool $has_orders
 * @var WC_Order_Query|WP_Query $customer_orders
 */
defined('ABSPATH') || exit;

$has_orders = isset($has_orders) ? (bool) $has_orders : false;
$current_page = isset($current_page) ? max(1, absint($current_page)) : 1;
?>

<div class="space-y-6">
	<div class="flex flex-wrap items-end justify-between gap-4">
		<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Orders', 'woocommerce'); ?></h2>
	</div>

	<?php if ($has_orders && isset($customer_orders->orders) && is_array($customer_orders->orders)) : ?>
		<?php $orders = $customer_orders->orders; ?>

		<div class="space-y-4 md:hidden">
			<?php foreach ($orders as $customer_order) :
				$order = wc_get_order($customer_order);
				if (!$order) {
					continue;
				}
				?>
				<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
					<div class="flex items-start justify-between gap-4">
						<div>
							<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Order', 'woocommerce'); ?></p>
							<p class="mt-1 text-lg font-black text-[#003745]">#<?php echo esc_html($order->get_order_number()); ?></p>
						</div>
						<span class="rounded-full border border-[#003745]/15 bg-[#003745]/5 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-[#003745]">
							<?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
						</span>
					</div>

					<div class="mt-4 grid grid-cols-2 gap-3 text-sm">
						<div>
							<p class="text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Date', 'woocommerce'); ?></p>
							<p class="font-semibold text-[#003745]"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></p>
						</div>
						<div>
							<p class="text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Total', 'woocommerce'); ?></p>
							<p class="font-semibold text-[#003745]"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></p>
						</div>
					</div>

					<div class="mt-5">
						<a class="inline-flex w-full items-center justify-center rounded-full bg-[#003745] px-5 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" href="<?php echo esc_url($order->get_view_order_url()); ?>">
							<?php esc_html_e('View', 'woocommerce'); ?>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="hidden overflow-x-auto md:block">
			<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders min-w-full text-sm">
				<thead>
					<tr class="border-b border-[#003745]/10 text-left uppercase tracking-[0.18em] text-[#1F525E]">
						<th class="py-3 pr-4 font-semibold"><?php esc_html_e('Order', 'woocommerce'); ?></th>
						<th class="py-3 pr-4 font-semibold"><?php esc_html_e('Date', 'woocommerce'); ?></th>
						<th class="py-3 pr-4 font-semibold"><?php esc_html_e('Status', 'woocommerce'); ?></th>
						<th class="py-3 pr-4 text-right font-semibold"><?php esc_html_e('Total', 'woocommerce'); ?></th>
						<th class="py-3 text-right font-semibold"><?php esc_html_e('Actions', 'woocommerce'); ?></th>
					</tr>
				</thead>
				<tbody class="divide-y divide-[#003745]/10">
					<?php foreach ($orders as $customer_order) :
						$order = wc_get_order($customer_order);
						if (!$order) {
							continue;
						}

						$actions = wc_get_account_orders_actions($order);
						?>
						<tr class="woocommerce-orders-table__row">
							<td class="py-4 pr-4 font-semibold text-[#003745]">
								<a class="underline decoration-[#FF2030] decoration-2 underline-offset-4" href="<?php echo esc_url($order->get_view_order_url()); ?>">
									#<?php echo esc_html($order->get_order_number()); ?>
								</a>
							</td>
							<td class="py-4 pr-4 text-[#1F525E]"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></td>
							<td class="py-4 pr-4 text-[#1F525E]"><?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></td>
							<td class="py-4 pr-4 text-right text-[#1F525E]"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></td>
							<td class="py-4 text-right">
								<div class="flex flex-wrap justify-end gap-2">
									<?php foreach ($actions as $key => $action) : ?>
										<a class="inline-flex items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:shadow-sm" href="<?php echo esc_url($action['url']); ?>">
											<?php echo esc_html($action['name']); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<?php do_action('woocommerce_before_account_orders_pagination'); ?>

		<?php if (isset($customer_orders->max_num_pages) && $customer_orders->max_num_pages > 1) : ?>
			<nav class="woocommerce-pagination mt-8 flex justify-center">
				<div class="flex flex-wrap items-center justify-center gap-2">
					<?php if (1 !== $current_page) : ?>
						<a class="inline-flex h-10 items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">
							<?php esc_html_e('Previous', 'woocommerce'); ?>
						</a>
					<?php endif; ?>
					<?php if ((int) $customer_orders->max_num_pages !== (int) $current_page) : ?>
						<a class="inline-flex h-10 items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">
							<?php esc_html_e('Next', 'woocommerce'); ?>
						</a>
					<?php endif; ?>
				</div>
			</nav>
		<?php endif; ?>
	<?php else : ?>
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 text-sm text-[#1F525E] shadow-sm">
			<p><?php esc_html_e('No order has been made yet.', 'woocommerce'); ?></p>
			<p class="mt-4">
				<a class="inline-flex items-center justify-center rounded-full bg-[#FF2030] px-5 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
					<?php esc_html_e('Browse products', 'woocommerce'); ?>
				</a>
			</p>
		</div>
	<?php endif; ?>
</div>


