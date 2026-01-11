<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();

while (have_posts()) :
	the_post();
	$bag_post_id = get_the_ID();
	$bag = function_exists('popbag_get_bag_data') ? popbag_get_bag_data($bag_post_id) : ['capacity' => 1, 'limits' => [], 'slug' => '', 'label' => get_the_title(), 'post_id' => $bag_post_id];
	$products_ids = function_exists('poppins_get_products_for_bag_post') ? poppins_get_products_for_bag_post($bag_post_id) : [];
	?>

	<main class="bg-white">
		<div class="mx-auto max-w-6xl px-6 py-12">
			<div class="grid gap-10 md:grid-cols-2">
				<div class="space-y-4">
					<div class="overflow-hidden rounded-[16px] border border-[#003745]/10 bg-white shadow-sm">
						<?php if (has_post_thumbnail()) : ?>
							<?php the_post_thumbnail('large', ['class' => 'h-full w-full object-cover']); ?>
						<?php else : ?>
							<div class="aspect-[4/5] bg-[#003745]/5"></div>
						<?php endif; ?>
					</div>
					<?php if (get_the_excerpt()) : ?>
						<p class="text-[#1F525E]"><?php echo esc_html(get_the_excerpt()); ?></p>
					<?php endif; ?>
				</div>

				<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
					<p class="text-sm uppercase tracking-[0.3em] text-[#1F525E]"><?php esc_html_e('Bag', 'popbag-minimal'); ?></p>
					<h1 class="mt-2 text-3xl font-black text-[#003745]"><?php the_title(); ?></h1>

					<div class="mt-4 text-sm text-[#1F525E]">
						<?php
						printf(
							/* translators: %d: capacity */
							esc_html__('Select up to %d products.', 'popbag-minimal'),
							absint($bag['capacity'] ?? 1)
						);
						?>
					</div>

					<?php if (function_exists('woocommerce_output_all_notices')) : ?>
						<div class="mt-4"><?php woocommerce_output_all_notices(); ?></div>
					<?php endif; ?>

					<form method="post" class="mt-6 space-y-4">
						<?php wp_nonce_field('popbag_add_bag_to_cart', 'popbag_bag_nonce'); ?>

						<div class="space-y-3">
							<p class="text-sm font-semibold text-[#003745]"><?php esc_html_e('Choose products', 'popbag-minimal'); ?></p>

							<?php if ($products_ids) : ?>
								<div class="max-h-[420px] overflow-auto rounded-[14px] border border-[#003745]/10 p-4">
									<ul class="space-y-3">
										<?php foreach ($products_ids as $product_id) :
											$product = function_exists('wc_get_product') ? wc_get_product($product_id) : null;
											if (!$product) {
												continue;
											}
											?>
											<li class="flex items-start gap-3">
												<input
													type="checkbox"
													name="popbag_bag_products[]"
													value="<?php echo esc_attr($product_id); ?>"
													class="mt-1 h-4 w-4 rounded border-[#003745]/30 text-[#FF2030] focus:ring-[#FF2030]/20"
												/>
												<div class="min-w-0">
													<p class="font-semibold text-[#003745]"><?php echo esc_html($product->get_name()); ?></p>
													<p class="text-sm text-[#1F525E]"><?php echo wp_kses_post($product->get_price_html()); ?></p>
												</div>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php else : ?>
								<p class="text-sm text-[#1F525E]"><?php esc_html_e('No products are available for this bag yet.', 'popbag-minimal'); ?></p>
							<?php endif; ?>
						</div>

						<button type="submit" class="w-full rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md">
							<?php esc_html_e('Add bag to cart', 'popbag-minimal'); ?>
						</button>
					</form>
				</div>
			</div>

			<div class="mt-12 rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<div class="prose max-w-none">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</main>

<?php endwhile; ?>

<?php
get_footer();



