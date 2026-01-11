<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main class="bg-white">
	<div class="mx-auto max-w-5xl px-6 py-12">
		<?php while (have_posts()) : the_post(); ?>
			<header class="mb-8 border-b border-[#003745]/10 pb-6">
				<h1 class="text-3xl font-black text-[#003745]"><?php the_title(); ?></h1>
			</header>

			<article class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<div class="prose max-w-none">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</main>

<?php
get_footer();



