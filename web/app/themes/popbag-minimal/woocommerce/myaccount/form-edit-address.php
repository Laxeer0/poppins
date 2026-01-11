<?php
/**
 * Edit address form.
 *
 * @var string $load_address
 */
defined('ABSPATH') || exit;

$customer_id  = get_current_user_id();
$load_address = isset($load_address) ? (string) $load_address : '';

if (!$load_address) {
	$load_address = isset($_GET['address']) ? wc_clean(wp_unslash($_GET['address'])) : 'billing'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

$load_address = in_array($load_address, ['billing', 'shipping'], true) ? $load_address : 'billing';

$countries = WC()->countries;

$country_meta_key = $load_address . '_country';
$country = (string) get_user_meta($customer_id, $country_meta_key, true);
$country = $country ? $country : $countries->get_base_country();

$address_fields = $countries->get_address_fields($country, $load_address . '_');
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]">
		<?php echo esc_html('billing' === $load_address ? __('Billing address', 'woocommerce') : __('Shipping address', 'woocommerce')); ?>
	</h2>

	<form method="post" class="woocommerce-EditAddressForm edit-address space-y-5">
		<?php do_action('woocommerce_before_edit_address_form_' . $load_address); ?>

		<div class="grid gap-4 md:grid-cols-2">
			<?php foreach ($address_fields as $key => $field) : ?>
				<?php
				$default_value  = get_user_meta($customer_id, $key, true);
				$field['value'] = wc_get_post_data_by_key($key, $default_value);
				woocommerce_form_field($key, $field, $field['value']);
				?>
			<?php endforeach; ?>
		</div>

		<?php do_action('woocommerce_after_edit_address_form_' . $load_address); ?>

		<div class="pt-2">
			<button type="submit" class="w-full rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" name="save_address" value="<?php esc_attr_e('Save address', 'woocommerce'); ?>">
				<?php esc_html_e('Save address', 'woocommerce'); ?>
			</button>
		</div>

		<?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
		<input type="hidden" name="action" value="edit_address" />
	</form>
</div>


