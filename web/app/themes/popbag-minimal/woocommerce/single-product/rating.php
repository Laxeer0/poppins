<?php
/**
 * Single Product Rating (theme-styled).
 *
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

if (!wc_review_ratings_enabled()) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = (float) $product->get_average_rating();

if ($rating_count <= 0) {
	return;
}

$full_stars = (int) floor($average);
$has_half   = ($average - $full_stars) >= 0.5;
$max_stars  = 5;
?>

<div class="woocommerce-product-rating flex flex-wrap items-center gap-x-3 gap-y-2">
	<div class="inline-flex items-center gap-1" aria-label="<?php echo esc_attr(sprintf(__('Rated %s out of 5', 'woocommerce'), wc_format_decimal($average, 1))); ?>">
		<?php for ($i = 1; $i <= $max_stars; $i++) : ?>
			<?php
			$is_full = $i <= $full_stars;
			$is_half = (!$is_full && $has_half && $i === ($full_stars + 1));
			$grad_id = 'popbag-star-grad-' . absint($product->get_id()) . '-' . absint($i);
			?>
			<svg class="h-4 w-4" viewBox="0 0 24 24" aria-hidden="true">
				<?php if ($is_half) : ?>
					<defs>
						<linearGradient id="<?php echo esc_attr($grad_id); ?>" x1="0" x2="1" y1="0" y2="0">
							<stop offset="50%" stop-color="#FFB100" />
							<stop offset="50%" stop-color="rgba(0,55,69,0.18)" />
						</linearGradient>
					</defs>
				<?php endif; ?>
				<path
					fill="<?php echo esc_attr($is_full ? '#FFB100' : ($is_half ? 'url(#' . $grad_id . ')' : 'rgba(0,55,69,0.18)')); ?>"
					d="M12 17.3l-6.18 3.25 1.18-6.88L2 8.97l6.91-1L12 1.7l3.09 6.27 6.91 1-5 4.7 1.18 6.88z"
				/>
			</svg>
		<?php endfor; ?>
		<span class="sr-only"><?php echo esc_html(sprintf(__('Rated %s out of 5', 'woocommerce'), wc_format_decimal($average, 1))); ?></span>
	</div>

	<?php if (comments_open()) : ?>
		<?php
		$reviews_label = sprintf(
			/* translators: %s: review count */
			_n('(%s recensione)', '(%s recensioni)', $review_count, 'popbag-minimal'),
			number_format_i18n($review_count)
		);
		?>
		<a href="#reviews" class="woocommerce-review-link text-sm font-semibold text-[#003745] underline decoration-[#FF2030] decoration-2 underline-offset-4" rel="nofollow">
			<?php echo esc_html($reviews_label); ?>
		</a>
	<?php endif; ?>
</div>

