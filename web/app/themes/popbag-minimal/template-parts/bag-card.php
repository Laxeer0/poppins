<?php
if (!defined('ABSPATH')) {
	exit;
}

$permalink = get_permalink();
$title = get_the_title();
?>

<article class="group relative h-full rounded-[16px] bg-white p-4 shadow-sm transition-transform hover:scale-105 after:pointer-events-none after:absolute after:inset-x-6 after:-bottom-1 after:h-6 after:rounded-full after:bg-[#003745]/25 after:blur-xl after:opacity-0 after:transition-opacity group-hover:after:opacity-100">
	<div class="flex h-full flex-col gap-4">
		<a href="<?php echo esc_url($permalink); ?>" class="flex flex-col gap-4">
			<div class="flex items-center justify-center overflow-hidden rounded-[14px] bg-white p-6">
				<?php if (has_post_thumbnail()) : ?>
					<?php the_post_thumbnail('thumbnail', ['class' => 'h-16 w-16 object-contain transition duration-300 group-hover:scale-105']); ?>
				<?php else : ?>
					<?php $ph = function_exists('popbag_asset_uri') ? popbag_asset_uri('assets/images/placeholder-bag.svg') : ''; ?>
					<?php if ($ph) : ?>
						<img src="<?php echo esc_url($ph); ?>" alt="<?php echo esc_attr($title); ?>" class="h-16 w-16 object-contain opacity-70 transition duration-300 group-hover:scale-105" loading="lazy" decoding="async" />
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<div class="flex items-start justify-between gap-4">
				<h2 class="text-lg font-black text-[#003745]">
					<?php echo esc_html($title); ?>
				</h2>
				<?php if (function_exists('popbag_get_bag_data')) :
					$bag = popbag_get_bag_data(get_the_ID());
					?>
					<span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]">
						<?php
						printf(
							/* translators: %d: capacity */
							esc_html__('%d capi', 'popbag-minimal'),
							absint($bag['capacity'] ?? 1)
						);
						?>
					</span>
				<?php endif; ?>
			</div>
		</a>

		<div class="mt-auto pt-2">
			<a href="<?php echo esc_url($permalink); ?>" class="button btn-primary flex w-full items-center justify-center px-6 py-3 text-xs transition group-hover:-translate-y-px group-hover:shadow-lg">
				<?php esc_html_e('Seleziona i capi', 'popbag-minimal'); ?>
			</a>
		</div>
	</div>
</article>



