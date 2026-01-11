<?php
/**
 * Result Count.
 */
defined('ABSPATH') || exit;

if (!$total) {
	return;
}
?>

<p class="woocommerce-result-count text-sm font-semibold uppercase tracking-[0.12em] text-[#1F525E]">
	<?php
	if ($total <= $per_page || -1 === $per_page) {
		/* translators: %d: total results */
		printf(esc_html__('%d results', 'woocommerce'), absint($total));
	} else {
		/* translators: 1: first result, 2: last result, 3: total results */
		printf(esc_html__('%1$d–%2$d of %3$d', 'woocommerce'), absint($first), absint($last), absint($total));
	}
	?>
</p>



