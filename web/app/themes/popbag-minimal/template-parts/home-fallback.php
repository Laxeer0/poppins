<?php
/**
 * Original mockup sections for the Home, used only when the front page has no Gutenberg content yet.
 */
if (!defined('ABSPATH')) {
	exit;
}

$shop_url = (string) ($args['shop_url'] ?? home_url('/shop'));
$render_product_swiper_section = $args['render_product_swiper_section'] ?? null;
if (!is_callable($render_product_swiper_section)) {
	return;
}
?>

<section class="relative overflow-hidden bg-white">
	<div class="mx-auto flex min-h-[70vh] max-w-6xl flex-col justify-center gap-10 px-6 py-16 md:flex-row md:items-center">
		<div class="max-w-2xl space-y-6">
			<p class="text-sm uppercase tracking-[0.3em] text-[#1F525E]">Minimal Premium</p>
			<h1 class="font-display text-5xl font-black leading-tight text-[#003745] md:text-6xl">FILL YOUR STYLE</h1>
			<p class="text-lg text-[#1F525E]">Borse essenziali, tagliate per una vita urbana elegante. Colori sobri, dettagli curati, spazio per tutto.</p>
			<div class="flex flex-wrap items-center gap-4">
				<a href="<?php echo esc_url($shop_url); ?>" class="rounded-full bg-[#FF2030] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white shadow-sm transition hover:-translate-y-px hover:shadow-md">Shop</a>
				<a href="#sizes" class="rounded-full border border-[#003745] px-6 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/60 hover:shadow-sm">Choose your size</a>
			</div>
		</div>
		<div class="relative w-full max-w-md self-end">
			<div class="rounded-[16px] border border-[#003745]/10 bg-white p-3 shadow-sm">
				<div class="grid grid-cols-2 gap-3">
					<?php $ph = function_exists('popbag_asset_uri') ? popbag_asset_uri('assets/images/placeholder-bag.svg') : ''; ?>
					<?php for ($i = 0; $i < 4; $i++) : ?>
						<div class="overflow-hidden rounded-[14px] border border-[#003745]/10 bg-[#003745]/5">
							<?php if ($ph) : ?>
								<img class="aspect-[4/5] h-full w-full object-cover" src="<?php echo esc_url($ph); ?>" alt="<?php echo esc_attr__('Bag placeholder', 'popbag-minimal'); ?>" />
							<?php endif; ?>
						</div>
					<?php endfor; ?>
				</div>
			</div>
			<div class="absolute -left-6 -top-6 rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#1F525E] shadow-sm">Minimal premium</div>
		</div>
	</div>
</section>

<?php
$bags_products = function_exists('popbag_get_new_arrivals') ? popbag_get_new_arrivals(12) : [];
$render_product_swiper_section([
	'title'     => 'Bags',
	'subtitle'  => 'Shop the essentials',
	'products'  => $bags_products,
	'cta_label' => 'Vedi tutto',
	'cta_url'   => $shop_url,
]);

$outfit_products = function_exists('popbag_get_products_by_category_slug') ? popbag_get_products_by_category_slug('outfit-premium', 12) : [];
$render_product_swiper_section([
	'title'     => 'Outfit Premium',
	'subtitle'  => 'Categoria',
	'products'  => $outfit_products,
	'cta_label' => 'Vedi categoria',
	'cta_url'   => $shop_url,
]);

$vintage_products = function_exists('popbag_get_products_by_category_slug') ? popbag_get_products_by_category_slug('vintage', 12) : [];
$render_product_swiper_section([
	'title'     => 'Vintage',
	'subtitle'  => 'Categoria',
	'products'  => $vintage_products,
	'cta_label' => 'Vedi categoria',
	'cta_url'   => $shop_url,
]);

$made_in_italy_products = function_exists('popbag_get_products_by_category_slug') ? popbag_get_products_by_category_slug('made-in-italy', 12) : [];
$render_product_swiper_section([
	'title'     => 'Made in Italy',
	'subtitle'  => 'Categoria',
	'products'  => $made_in_italy_products,
	'cta_label' => 'Vedi categoria',
	'cta_url'   => $shop_url,
]);

$not_made_in_italy_products = function_exists('popbag_get_products_by_category_slug') ? popbag_get_products_by_category_slug('not-made-in-italy', 12) : [];
$render_product_swiper_section([
	'title'     => 'Non Made in Italy',
	'subtitle'  => 'Categoria',
	'products'  => $not_made_in_italy_products,
	'cta_label' => 'Vedi categoria',
	'cta_url'   => $shop_url,
]);
?>

<section class="bg-white">
	<div class="mx-auto max-w-6xl px-6 py-16">
		<div class="grid gap-10 md:grid-cols-2 md:items-center">
			<div>
				<p class="text-sm uppercase tracking-[0.3em] text-[#1F525E]">Chi siamo</p>
				<h2 class="mt-2 text-3xl font-black text-[#003745]">Design essenziale, cura artigianale.</h2>
				<p class="mt-4 text-[#1F525E]">
					Placeholder testo: racconta POP BAG, la filosofia minimal premium, materiali e lavorazioni.
				</p>
			</div>
			<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
				<p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#003745]">Highlights</p>
				<ul class="mt-4 space-y-3 text-sm text-[#1F525E]">
					<li>Materiali selezionati</li>
					<li>Dettagli funzionali</li>
					<li>Palette colore curata</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="bg-white">
	<div class="mx-auto max-w-6xl px-6 py-16">
		<div class="grid gap-10 md:grid-cols-2 md:items-center">
			<div>
				<p class="text-sm uppercase tracking-[0.3em] text-[#1F525E]">Dove siamo</p>
				<h2 class="mt-2 text-3xl font-black text-[#003745]">Vieni a trovarci.</h2>
				<p class="mt-4 text-[#1F525E]">Placeholder indirizzo + orari + contatti.</p>
			</div>
			<div class="aspect-[16/10] overflow-hidden rounded-[16px] border border-[#003745]/10 bg-[#003745]/5 shadow-sm">
				<div class="flex h-full items-center justify-center text-sm font-semibold uppercase tracking-[0.2em] text-[#1F525E]">
					Map placeholder
				</div>
			</div>
		</div>
	</div>
</section>



