<?php
/**
 * Proceed to checkout button.
 */
defined('ABSPATH') || exit;
?>

<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="block w-full rounded-full bg-[#FF2030] px-6 py-3 text-center text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md">
	<?php esc_html_e('Proceed to checkout', 'woocommerce'); ?>
</a>



