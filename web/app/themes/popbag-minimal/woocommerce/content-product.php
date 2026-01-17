<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
	return;
}

$is_new = (time() - $product->get_date_created()->getTimestamp()) < DAY_IN_SECONDS * 30;
?>

<li <?php wc_product_class('h-full', $product); ?>>
	<article class="group flex h-full flex-col rounded-[16px] border border-[#003745]/10 bg-white p-4 shadow-sm transition-transform hover:scale-[1.03] hover:shadow-lg">
		<a href="<?php the_permalink(); ?>" class="flex flex-1 flex-col gap-4">
			<div class="relative overflow-hidden rounded-[14px] border border-[#003745]/10 bg-[#003745]/5">
				<?php if ($is_new) : ?>
					<span class="absolute left-3 top-3 rounded-full bg-[#FF2030] px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-white shadow-sm">New</span>
				<?php endif; ?>
				<div class="relative aspect-[4/5] overflow-hidden">
					<?php woocommerce_template_loop_product_thumbnail(); ?>
				</div>
			</div>
			<div class="flex items-start justify-between gap-4">
				<h2 class="text-lg font-black text-[#003745]"><?php the_title(); ?></h2>
				<div class="text-sm font-semibold text-[#1F525E]"><?php woocommerce_template_loop_price(); ?></div>
			</div>
		</a>

		<div class="mt-4">
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
	</article>
</li>



