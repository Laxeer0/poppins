<?php
/**
 * Reset password form (after clicking email link).
 *
 * @var string $reset_key
 * @var string $reset_login
 */
defined('ABSPATH') || exit;

$reset_key   = isset($reset_key) ? (string) $reset_key : '';
$reset_login = isset($reset_login) ? (string) $reset_login : '';
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Reset password', 'woocommerce'); ?></h2>

	<form method="post" class="woocommerce-ResetPassword lost_reset_password space-y-5">
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label class="block text-sm font-semibold text-[#003745]" for="password_1"><?php esc_html_e('New password', 'woocommerce'); ?></label>
			<input class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" type="password" name="password_1" id="password_1" autocomplete="new-password" />
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label class="block text-sm font-semibold text-[#003745]" for="password_2"><?php esc_html_e('Re-enter new password', 'woocommerce'); ?></label>
			<input class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" type="password" name="password_2" id="password_2" autocomplete="new-password" />
		</p>

		<input type="hidden" name="reset_key" value="<?php echo esc_attr($reset_key); ?>" />
		<input type="hidden" name="reset_login" value="<?php echo esc_attr($reset_login); ?>" />

		<?php do_action('woocommerce_resetpassword_form'); ?>

		<div class="pt-2">
			<?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
			<button type="submit" class="w-full rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" value="<?php esc_attr_e('Save', 'woocommerce'); ?>">
				<?php esc_html_e('Save', 'woocommerce'); ?>
			</button>
			<input type="hidden" name="wc_reset_password" value="true" />
		</div>
	</form>
</div>



