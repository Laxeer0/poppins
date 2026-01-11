<?php
/**
 * Lost password form.
 */
defined('ABSPATH') || exit;
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Lost password', 'woocommerce'); ?></h2>

	<div class="rounded-[16px] border border-[#003745]/10 bg-[#003745]/5 p-5 text-sm text-[#1F525E]">
		<?php echo wp_kses_post(__('Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce')); ?>
	</div>

	<form method="post" class="woocommerce-ResetPassword lost_reset_password space-y-5">
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label class="block text-sm font-semibold text-[#003745]" for="user_login">
				<?php esc_html_e('Username or email', 'woocommerce'); ?>
			</label>
			<input class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" type="text" name="user_login" id="user_login" autocomplete="username" />
		</p>

		<?php do_action('woocommerce_lostpassword_form'); ?>

		<div class="pt-2">
			<?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
			<button type="submit" class="w-full rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>">
				<?php esc_html_e('Reset password', 'woocommerce'); ?>
			</button>
			<input type="hidden" name="wc_reset_password" value="true" />
		</div>
	</form>
</div>



