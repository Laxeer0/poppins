<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main class="bg-white">
	<div class="mx-auto max-w-6xl px-6 py-12">
		<header class="mb-10 flex flex-col gap-3 border-b border-[#003745]/10 pb-6">
			<h1 class="text-3xl font-black text-[#003745]"><?php post_type_archive_title(); ?></h1>
			<?php if (term_description()) : ?>
				<div class="prose max-w-none text-[#1F525E]">
					<?php echo wp_kses_post(term_description()); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if (have_posts()) : ?>
			<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
				<?php while (have_posts()) : the_post(); ?>
					<?php get_template_part('template-parts/bag-card'); ?>
				<?php endwhile; ?>
			</div>

			<div class="mt-10">
				<?php the_posts_pagination(['mid_size' => 1]); ?>
			</div>
		<?php else : ?>
			<p class="text-[#1F525E]"><?php esc_html_e('No bags found.', 'popbag-minimal'); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();



