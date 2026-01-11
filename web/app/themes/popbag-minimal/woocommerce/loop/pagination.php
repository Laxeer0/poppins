<?php
/**
 * Pagination.
 */
defined('ABSPATH') || exit;

if ($total <= 1) {
	return;
}
?>

<nav class="woocommerce-pagination mt-10 flex justify-center" aria-label="<?php esc_attr_e('Products', 'woocommerce'); ?>">
	<?php
	$links = paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			[
				'base'      => esc_url_raw(add_query_arg('product-page', '%#%', false)),
				'format'    => '',
				'add_args'  => false,
				'current'   => max(1, absint($current)),
				'total'     => absint($total),
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'array',
				'end_size'  => 1,
				'mid_size'  => 1,
			]
		)
	);

	if (!empty($links) && is_array($links)) {
		echo '<div class="flex flex-wrap items-center justify-center gap-2">';
		foreach ($links as $link) {
			// Add classes to anchor/span.
			$link = str_replace('page-numbers', 'page-numbers inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-full border border-[#003745]/15 bg-white px-3 text-sm font-semibold text-[#003745] hover:-translate-y-px hover:shadow-sm', $link);
			$link = str_replace('current', 'current border-[#003745]/40 bg-[#003745]/5', $link);
			echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
	}
	?>
</nav>


