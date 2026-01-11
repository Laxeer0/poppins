<?php
/**
 * My Account addresses.
 */
defined('ABSPATH') || exit;

$customer_id = get_current_user_id();
$get_addresses = apply_filters(
	'woocommerce_my_account_get_addresses',
	[
		'billing'  => __('Billing address', 'woocommerce'),
		'shipping' => __('Shipping address', 'woocommerce'),
	],
	$customer_id
);
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Addresses', 'woocommerce'); ?></h2>

	<div class="grid gap-6 md:grid-cols-2">
		<?php foreach ($get_addresses as $name => $title) : ?>
			<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<div class="flex items-start justify-between gap-4">
					<div>
						<p class="text-sm uppercase tracking-[0.18em] text-[#1F525E]"><?php echo esc_html($title); ?></p>
					</div>
					<a class="inline-flex items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:shadow-sm" href="<?php echo esc_url(wc_get_endpoint_url('edit-address', $name)); ?>">
						<?php esc_html_e('Edit', 'woocommerce'); ?>
					</a>
				</div>

				<div class="mt-4 rounded-[14px] border border-[#003745]/10 bg-[#003745]/5 p-4 text-sm text-[#003745]">
					<?php
					$address = wc_get_account_formatted_address($name);
					echo $address ? wp_kses_post($address) : esc_html__('You have not set up this type of address yet.', 'woocommerce');
					?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>



