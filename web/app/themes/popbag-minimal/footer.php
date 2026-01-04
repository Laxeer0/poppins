<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<footer class="border-t border-[#003745]/10 bg-white/80">
	<div class="mx-auto flex max-w-6xl flex-col gap-6 px-6 py-10 md:flex-row md:items-center md:justify-between">
		<div>
			<p class="text-sm uppercase tracking-[0.18em] text-[#1F525E]">Pop Bag</p>
			<p class="mt-2 text-base text-[#003745]">Minimal premium essentials for your style.</p>
		</div>
		<nav class="text-sm">
			<?php
			wp_nav_menu([
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'flex flex-wrap items-center gap-4 uppercase tracking-[0.12em]',
				'fallback_cb'    => false,
			]);
			?>
		</nav>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>



