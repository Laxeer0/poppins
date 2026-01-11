<?php
/**
 * Gutenberg patterns (mockup sections starter).
 */
if (!defined('ABSPATH')) {
	exit;
}

add_action('init', static function (): void {
	if (!function_exists('register_block_pattern')) {
		return;
	}

	if (function_exists('register_block_pattern_category')) {
		register_block_pattern_category('popbag', [
			'label' => __('POP BAG', 'popbag-minimal'),
		]);
	}

	$hero_html = '
<section class="relative overflow-hidden bg-white">
  <div class="mx-auto flex min-h-[70vh] max-w-6xl flex-col justify-center gap-10 px-6 py-16 md:flex-row md:items-center">
    <div class="max-w-2xl space-y-6">
      <p class="text-sm uppercase tracking-[0.3em] text-[#1F525E]">Minimal Premium</p>
      <h1 class="font-display text-5xl font-black leading-tight text-[#003745] md:text-6xl">FILL YOUR STYLE</h1>
      <p class="text-lg text-[#1F525E]">Borse essenziali, tagliate per una vita urbana elegante. Colori sobri, dettagli curati, spazio per tutto.</p>
      <div class="flex flex-wrap items-center gap-4">
        <a href="/shop/" class="rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white shadow-sm transition hover:-translate-y-px hover:shadow-md">Shop</a>
        <a href="#sizes" class="rounded-full border border-[#003745] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/60 hover:shadow-sm">Choose your size</a>
      </div>
    </div>
  </div>
</section>';

	$content = implode("\n", [
		'<!-- wp:html -->',
		$hero_html,
		'<!-- /wp:html -->',
		'<!-- wp:shortcode -->',
		'[popbag_product_swiper title="Bags" subtitle="Shop the essentials" source="new" limit="12" cta_label="Vedi tutto" cta_url="/shop/"]',
		'<!-- /wp:shortcode -->',
		'<!-- wp:shortcode -->',
		'[popbag_product_swiper title="Vintage" subtitle="Categoria" source="category" category="vintage" limit="12" cta_label="Vedi categoria" cta_url="/shop/"]',
		'<!-- /wp:shortcode -->',
	]);

	register_block_pattern('popbag/home-starter', [
		'title'       => __('Home starter (mockup)', 'popbag-minimal'),
		'description' => __('Starter layout for Home using mockup sections + shortcodes.', 'popbag-minimal'),
		'categories'  => ['popbag'],
		'content'     => $content,
	]);
});



