<?php
if (!defined('ABSPATH')) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('bg-[#F9E2B0] text-[#003745]'); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-40 border-b border-[#003745]/10 bg-[#F9E2B0]/90 backdrop-blur">
	<div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
		<div class="flex items-center gap-4">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 text-lg font-black tracking-tight">
				<span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#003745]/20 bg-white text-xl">PB</span>
				<span class="uppercase leading-none">Pop Bag</span>
			</a>
		</div>
		<nav class="hidden items-center gap-6 text-sm font-semibold uppercase tracking-[0.12em] md:flex">
			<?php
			wp_nav_menu([
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'flex items-center gap-6',
				'fallback_cb'    => false,
			]);
			?>
		</nav>
		<?php $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart'); ?>
		<div class="flex items-center gap-3">
			<form role="search" method="get" class="relative" action="<?php echo esc_url(home_url('/')); ?>">
				<label class="sr-only" for="popbag-search">Search</label>
				<input id="popbag-search" class="hidden" type="search" name="s" />
				<button type="submit" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#003745]/15 bg-white text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/30 hover:shadow-sm">
					<span aria-hidden="true">
						<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
							<circle cx="11" cy="11" r="7"></circle>
							<path d="m16 16 4 4"></path>
						</svg>
					</span>
					<span class="sr-only"><?php esc_html_e('Search', 'popbag-minimal'); ?></span>
				</button>
			</form>
			<a href="<?php echo esc_url($cart_url); ?>" class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#003745]/15 bg-white text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/30 hover:shadow-sm">
				<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
					<path d="M3 4h2l1.6 9.2a1 1 0 0 0 1 .8h7.8a1 1 0 0 0 1-.8L17 7H6"></path>
					<circle cx="9" cy="19" r="1"></circle>
					<circle cx="15" cy="19" r="1"></circle>
				</svg>
				<?php if (function_exists('WC')) : ?>
					<span class="absolute -right-1 -top-1 inline-flex min-w-[1.4rem] items-center justify-center rounded-full bg-[#FF2030] px-1.5 text-xs font-bold text-white shadow-sm">
						<?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
					</span>
				<?php endif; ?>
				<span class="sr-only"><?php esc_html_e('View cart', 'popbag-minimal'); ?></span>
			</a>
		</div>
	</div>
</header>

