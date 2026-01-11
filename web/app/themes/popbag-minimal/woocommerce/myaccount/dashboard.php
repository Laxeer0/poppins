<?php
/**
 * My Account dashboard.
 */
defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$display_name = $current_user instanceof WP_User ? $current_user->display_name : '';
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Dashboard', 'woocommerce'); ?></h2>

	<div class="rounded-[16px] border border-[#003745]/10 bg-[#003745]/5 p-5">
		<p class="text-sm text-[#1F525E]">
			<?php
			printf(
				/* translators: 1: user display name, 2: logout url */
				wp_kses_post(__('Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce')),
				esc_html($display_name),
				esc_url(wc_logout_url())
			);
			?>
		</p>
		<p class="mt-3 text-sm text-[#1F525E]">
			<?php echo wp_kses_post(__('From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.', 'woocommerce')); ?>
		</p>
	</div>

	<?php do_action('woocommerce_account_dashboard'); ?>
	<?php do_action('woocommerce_before_my_account'); ?>
	<?php do_action('woocommerce_after_my_account'); ?>
</div>



