<?php
/**
 * Lost password confirmation (after reset link is sent).
 *
 * @package WooCommerce\Templates
 */
defined('ABSPATH') || exit;
?>

<div class="woo-account">
	<div class="space-y-6">
		<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Reset password', 'woocommerce'); ?></h2>

		<div class="rounded-[16px] border border-[#003745]/10 bg-[#003745]/5 p-5 text-sm text-[#1F525E]">
			<?php echo wp_kses_post(__('Password reset email has been sent.', 'woocommerce')); ?>
		</div>

		<p class="text-sm">
			<a class="font-semibold text-[#003745] underline decoration-[#FF2030] decoration-2 underline-offset-4" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
				<?php esc_html_e('Back to login', 'woocommerce'); ?>
			</a>
		</p>
	</div>
</div>

