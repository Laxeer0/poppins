<?php
/**
 * Product Search Form (WooCommerce).
 */
if (!defined('ABSPATH')) {
	exit;
}

$search_query = get_search_query();
?>

<form role="search" method="get" class="relative" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="sr-only" for="woocommerce-product-search-field"><?php esc_html_e('Search products:', 'woocommerce'); ?></label>
	<div class="flex items-center gap-2 rounded-full border border-[#003745]/15 bg-white px-3 py-2 shadow-sm">
		<svg class="h-4 w-4 text-[#1F525E]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
			<circle cx="11" cy="11" r="7"></circle>
			<path d="m16 16 4 4"></path>
		</svg>
		<input
			type="search"
			id="woocommerce-product-search-field"
			class="w-44 bg-transparent text-sm text-[#003745] placeholder-[#1F525E]/60 focus:outline-none"
			placeholder="<?php echo esc_attr__('Search products…', 'woocommerce'); ?>"
			value="<?php echo esc_attr($search_query); ?>"
			name="s"
		/>
	</div>
	<input type="hidden" name="post_type" value="product" />
</form>



