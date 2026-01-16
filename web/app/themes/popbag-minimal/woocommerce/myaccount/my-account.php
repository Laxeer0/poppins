<?php
/**
 * My Account dashboard wrapper.
 */
defined('ABSPATH') || exit;
?>

<div class="woo-account">
	<div class="grid gap-8 md:grid-cols-[260px_1fr]">
		<nav class="woocommerce-MyAccount-navigation rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
			<?php do_action('woocommerce_account_navigation'); ?>
		</nav>

		<div class="woocommerce-MyAccount-content rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
			<?php do_action('woocommerce_account_content'); ?>
		</div>
	</div>
</div>


