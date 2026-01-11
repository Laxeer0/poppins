<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main class="min-h-[60vh] bg-white">
	<div class="mx-auto max-w-5xl px-6 py-16 text-center">
		<p class="text-sm uppercase tracking-[0.3em] text-[#1F525E]"><?php esc_html_e('Error 404', 'popbag-minimal'); ?></p>
		<h1 class="mt-3 text-4xl font-black text-[#003745]"><?php esc_html_e('Page not found', 'popbag-minimal'); ?></h1>
		<p class="mx-auto mt-4 max-w-xl text-[#1F525E]"><?php esc_html_e('The page you are looking for does not exist or has been moved.', 'popbag-minimal'); ?></p>

		<div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white shadow-sm transition hover:-translate-y-px hover:shadow-md">
				<?php esc_html_e('Go to homepage', 'popbag-minimal'); ?>
			</a>
			<a href="<?php echo esc_url(home_url('/?s=')); ?>" class="rounded-full border border-[#003745] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/60 hover:shadow-sm">
				<?php esc_html_e('Search', 'popbag-minimal'); ?>
			</a>
		</div>
	</div>
</main>

<?php
get_footer();



