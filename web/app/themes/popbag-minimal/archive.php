<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main class="bg-white">
	<div class="mx-auto max-w-6xl px-6 py-12">
		<header class="mb-10 border-b border-[#003745]/10 pb-6">
			<h1 class="text-3xl font-black text-[#003745]"><?php the_archive_title(); ?></h1>
			<?php $desc = get_the_archive_description(); ?>
			<?php if ($desc) : ?>
				<div class="mt-3 text-[#1F525E]"><?php echo wp_kses_post($desc); ?></div>
			<?php endif; ?>
		</header>

		<?php if (have_posts()) : ?>
			<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
				<?php while (have_posts()) : the_post(); ?>
					<?php get_template_part('template-parts/post-card'); ?>
				<?php endwhile; ?>
			</div>

			<div class="mt-10">
				<?php the_posts_pagination(['mid_size' => 1]); ?>
			</div>
		<?php else : ?>
			<p class="text-[#1F525E]"><?php esc_html_e('No posts found.', 'popbag-minimal'); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();


