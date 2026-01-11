<?php
if (!defined('ABSPATH')) {
	exit;
}

if (post_password_required()) {
	return;
}
?>

<section id="comments" class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
	<?php if (have_comments()) : ?>
		<h2 class="text-xl font-black text-[#003745]">
			<?php
			printf(
				/* translators: %d: comments count */
				esc_html(_n('%d Comment', '%d Comments', get_comments_number(), 'popbag-minimal')),
				absint(get_comments_number())
			);
			?>
		</h2>

		<ol class="mt-6 space-y-6">
			<?php
			wp_list_comments([
				'style'      => 'ol',
				'short_ping' => true,
			]);
			?>
		</ol>

		<div class="mt-6">
			<?php the_comments_navigation(); ?>
		</div>
	<?php endif; ?>

	<?php if (!comments_open()) : ?>
		<p class="mt-6 text-sm text-[#1F525E]"><?php esc_html_e('Comments are closed.', 'popbag-minimal'); ?></p>
	<?php endif; ?>

	<div class="mt-8">
		<?php comment_form(); ?>
	</div>
</section>



