<?php
/**
 * Product card partial.
 *
 * Expects $args['product'] (WC_Product) and optional $args['show_badge'] (bool).
 */

if (!defined('ABSPATH')) {
	exit;
}

$product    = $args['product'] ?? null;
$show_badge = $args['show_badge'] ?? false;

if (!$product instanceof WC_Product) {
	return;
}

$is_new = (time() - $product->get_date_created()->getTimestamp()) < DAY_IN_SECONDS * 30;
?>

<article class="group h-full rounded-[16px] border border-[#003745]/10 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
	<a href="<?php echo esc_url($product->get_permalink()); ?>" class="flex h-full flex-col gap-4">
		<div class="relative overflow-hidden rounded-[14px] border border-[#003745]/10 bg-[#003745]/5">
			<?php if ($show_badge && $is_new) : ?>
				<span class="absolute left-3 top-3 rounded-full bg-[#FF2030] px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-white shadow-sm">New</span>
			<?php endif; ?>
			<div class="relative aspect-[4/5] overflow-hidden">
				<?php echo $product->get_image('woocommerce_single', ['class' => 'h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]']); ?>
			</div>
		</div>
		<div class="flex items-start justify-between gap-4">
			<h3 class="text-lg font-black text-[#003745] underline-offset-4 transition group-hover:underline">
				<?php echo esc_html($product->get_name()); ?>
			</h3>
			<span class="text-sm font-semibold text-[#1F525E]"><?php echo wp_kses_post($product->get_price_html()); ?></span>
		</div>
	</a>
</article>



