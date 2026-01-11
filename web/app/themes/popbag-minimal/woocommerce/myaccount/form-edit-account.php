<?php
/**
 * Edit account details form.
 */
defined('ABSPATH') || exit;

$user = wp_get_current_user();
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Account details', 'woocommerce'); ?></h2>

	<form class="woocommerce-EditAccountForm edit-account space-y-5" action="" method="post">
		<?php do_action('woocommerce_edit_account_form_start'); ?>

		<div class="grid gap-4 md:grid-cols-2">
			<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
				<label class="block text-sm font-semibold text-[#003745]" for="account_first_name">
					<?php esc_html_e('First name', 'woocommerce'); ?>
					<span class="required" aria-hidden="true">*</span>
				</label>
				<input type="text" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" />
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
				<label class="block text-sm font-semibold text-[#003745]" for="account_last_name">
					<?php esc_html_e('Last name', 'woocommerce'); ?>
					<span class="required" aria-hidden="true">*</span>
				</label>
				<input type="text" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" />
			</p>
		</div>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label class="block text-sm font-semibold text-[#003745]" for="account_display_name">
				<?php esc_html_e('Display name', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
			</label>
			<input type="text" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" />
			<span class="mt-2 block text-xs text-[#1F525E]">
				<?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?>
			</span>
		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label class="block text-sm font-semibold text-[#003745]" for="account_email">
				<?php esc_html_e('Email address', 'woocommerce'); ?>
				<span class="required" aria-hidden="true">*</span>
			</label>
			<input type="email" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" />
		</p>

		<div class="rounded-[16px] border border-[#003745]/10 bg-[#003745]/5 p-5">
			<h3 class="text-base font-black text-[#003745]"><?php esc_html_e('Password change', 'woocommerce'); ?></h3>
			<div class="mt-4 grid gap-4">
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label class="block text-sm font-semibold text-[#003745]" for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
					<input type="password" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="password_current" id="password_current" autocomplete="current-password" />
				</p>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label class="block text-sm font-semibold text-[#003745]" for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
					<input type="password" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="password_1" id="password_1" autocomplete="new-password" />
				</p>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label class="block text-sm font-semibold text-[#003745]" for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
					<input type="password" class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20" name="password_2" id="password_2" autocomplete="new-password" />
				</p>
			</div>
		</div>

		<?php do_action('woocommerce_edit_account_form'); ?>

		<div class="pt-2">
			<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
			<button type="submit" class="w-full rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" name="save_account_details" value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>">
				<?php esc_html_e('Save changes', 'woocommerce'); ?>
			</button>
			<input type="hidden" name="action" value="save_account_details" />
		</div>

		<?php do_action('woocommerce_edit_account_form_end'); ?>
	</form>
</div>



