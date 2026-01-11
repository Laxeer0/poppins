<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main class="bg-white">
	<div class="mx-auto max-w-5xl px-6 py-12">
		<?php while (have_posts()) : the_post(); ?>
			<article class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<header class="mb-6 border-b border-[#003745]/10 pb-6">
					<p class="text-sm uppercase tracking-[0.18em] text-[#1F525E]">
						<?php echo esc_html(get_the_date()); ?>
					</p>
					<h1 class="mt-2 text-3xl font-black text-[#003745]"><?php the_title(); ?></h1>
				</header>

				<?php if (has_post_thumbnail()) : ?>
					<div class="mb-8 overflow-hidden rounded-[16px] border border-[#003745]/10">
						<?php the_post_thumbnail('large', ['class' => 'h-full w-full object-cover']); ?>
					</div>
				<?php endif; ?>

				<div class="prose max-w-none">
					<?php the_content(); ?>
				</div>

				<footer class="mt-10 border-t border-[#003745]/10 pt-6 text-sm text-[#1F525E]">
					<?php the_tags('<span class="font-semibold text-[#003745]">Tags:</span> ', ', '); ?>
				</footer>
			</article>

			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="mt-10">
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</main>

<?php
get_footer();



