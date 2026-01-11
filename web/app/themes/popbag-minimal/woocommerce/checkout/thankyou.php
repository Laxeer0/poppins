<?php
/**
 * Thank you page.
 */
defined('ABSPATH') || exit;

if ($order) : ?>

	<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
		<?php if ($order->has_status('failed')) : ?>
			<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Order failed', 'woocommerce'); ?></h2>
			<p class="mt-3 text-sm text-[#1F525E]"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce'); ?></p>
			<div class="mt-6 flex flex-wrap gap-3">
				<a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md">
					<?php esc_html_e('Pay', 'woocommerce'); ?>
				</a>
				<?php if (is_user_logged_in()) : ?>
					<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="rounded-full border border-[#003745] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/60 hover:shadow-sm">
						<?php esc_html_e('My account', 'woocommerce'); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Thank you. Your order has been received.', 'woocommerce'); ?></h2>

			<ul class="mt-6 grid gap-4 rounded-[14px] border border-[#003745]/10 bg-[#003745]/5 p-4 text-sm text-[#003745] sm:grid-cols-2">
				<li>
					<span class="block text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Order number', 'woocommerce'); ?></span>
					<span class="mt-1 block font-semibold"><?php echo esc_html($order->get_order_number()); ?></span>
				</li>
				<li>
					<span class="block text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Date', 'woocommerce'); ?></span>
					<span class="mt-1 block font-semibold"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></span>
				</li>
				<li>
					<span class="block text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Total', 'woocommerce'); ?></span>
					<span class="mt-1 block font-semibold"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
				</li>
				<?php if ($order->get_payment_method_title()) : ?>
					<li>
						<span class="block text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Payment method', 'woocommerce'); ?></span>
						<span class="mt-1 block font-semibold"><?php echo esc_html($order->get_payment_method_title()); ?></span>
					</li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
	<?php do_action('woocommerce_thankyou', $order->get_id()); ?>

<?php else : ?>

	<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
		<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Thank you. Your order has been received.', 'woocommerce'); ?></h2>
	</div>

<?php endif; ?>



