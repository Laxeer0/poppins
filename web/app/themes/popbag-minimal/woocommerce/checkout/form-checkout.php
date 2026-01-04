<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
	<div class="grid gap-8 md:grid-cols-2">
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
			<h3 class="text-xl font-black text-[#003745]"><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
			<div class="mt-6 space-y-4">
				<?php do_action('woocommerce_checkout_before_customer_details'); ?>
				<div id="customer_details" class="grid gap-4">
					<?php do_action('woocommerce_checkout_billing'); ?>
					<?php do_action('woocommerce_checkout_shipping'); ?>
				</div>
				<?php do_action('woocommerce_checkout_after_customer_details'); ?>
			</div>
		</div>

		<div class="space-y-6">
			<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<h3 class="text-xl font-black text-[#003745]"><?php esc_html_e('Order summary', 'woocommerce'); ?></h3>
				<div class="mt-4">
					<?php do_action('woocommerce_checkout_before_order_review'); ?>
					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action('woocommerce_checkout_order_review'); ?>
					</div>
					<?php do_action('woocommerce_checkout_after_order_review'); ?>
				</div>
			</div>
			<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<h3 class="text-xl font-black text-[#003745]"><?php esc_html_e('Payment', 'woocommerce'); ?></h3>
				<div class="mt-4 space-y-4">
					<?php
					if (WC()->cart->needs_payment()) {
						wc_get_template('checkout/payment.php', ['checkout' => $checkout]);
					}
					?>
					<?php do_action('woocommerce_review_order_before_submit'); ?>
					<button type="submit" class="w-full rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" name="woocommerce_checkout_place_order" id="place_order" value="<?php echo esc_attr($checkout->get_checkout_payment_url()); ?>" data-value="<?php echo esc_attr__('Place order', 'woocommerce'); ?>">
						<?php esc_html_e('Place order', 'woocommerce'); ?>
					</button>
					<?php do_action('woocommerce_review_order_after_submit'); ?>
				</div>
			</div>
		</div>
	</div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>



