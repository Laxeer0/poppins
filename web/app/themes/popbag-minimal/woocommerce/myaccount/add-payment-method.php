<?php
/**
 * Add payment method.
 */
defined('ABSPATH') || exit;
?>

<div class="woo-account">
	<div class="space-y-6">
		<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Add payment method', 'woocommerce'); ?></h2>

		<form id="add_payment_method" method="post" class="space-y-5">
			<?php do_action('woocommerce_add_payment_method_form_start'); ?>

		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
			<?php
			$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
			$available_gateways = apply_filters('woocommerce_available_payment_gateways', $available_gateways);

			if (!empty($available_gateways)) :
				?>
				<ul class="space-y-3">
					<?php foreach ($available_gateways as $gateway) : ?>
						<li class="rounded-[14px] border border-[#003745]/10 p-4">
							<?php
							wc_get_template('checkout/payment-method.php', [
								'gateway' => $gateway,
							]);
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="text-sm text-[#1F525E]"><?php esc_html_e('No payment methods are available for your account.', 'woocommerce'); ?></p>
			<?php endif; ?>
		</div>

			<?php do_action('woocommerce_add_payment_method_form_end'); ?>

			<div class="pt-2">
				<?php wp_nonce_field('woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce'); ?>
				<button type="submit" class="<?php echo esc_attr(popbag_button_classes('primary', 'md', 'w-full')); ?>" id="place_order" value="<?php esc_attr_e('Add payment method', 'woocommerce'); ?>">
					<?php esc_html_e('Add payment method', 'woocommerce'); ?>
				</button>
				<input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
			</div>
		</form>
	</div>
</div>


