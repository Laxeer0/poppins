<?php
if (!defined('ABSPATH')) {
	exit;
}

$permalink = get_permalink();
$title = get_the_title();
?>

<article class="group h-full rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
	<a href="<?php echo esc_url($permalink); ?>" class="flex h-full flex-col gap-4">
		<?php if (has_post_thumbnail()) : ?>
			<div class="overflow-hidden rounded-[14px] border border-[#003745]/10">
				<?php the_post_thumbnail('medium_large', ['class' => 'h-48 w-full object-cover transition duration-300 group-hover:scale-[1.03]']); ?>
			</div>
		<?php endif; ?>

		<div class="flex-1">
			<p class="text-xs uppercase tracking-[0.18em] text-[#1F525E]"><?php echo esc_html(get_the_date()); ?></p>
			<h2 class="mt-2 text-lg font-black text-[#003745] underline-offset-4 transition group-hover:underline">
				<?php echo esc_html($title); ?>
			</h2>
			<p class="mt-3 text-sm text-[#1F525E]">
				<?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?>
			</p>
		</div>

		<span class="text-sm font-semibold text-[#003745] underline decoration-[#FF2030] decoration-2 underline-offset-4">
			<?php esc_html_e('Read more', 'popbag-minimal'); ?>
		</span>
	</a>
</article>



