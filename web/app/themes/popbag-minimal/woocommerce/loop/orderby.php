<?php
/**
 * Catalog ordering.
 */
defined('ABSPATH') || exit;
?>

<form class="woocommerce-ordering" method="get">
	<label class="sr-only" for="orderby"><?php esc_html_e('Sort by', 'woocommerce'); ?></label>
	<select name="orderby" class="rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" aria-label="<?php esc_attr_e('Shop order', 'woocommerce'); ?>">
		<?php foreach ($catalog_orderby_options as $id => $name) : ?>
			<option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']); ?>
</form>



