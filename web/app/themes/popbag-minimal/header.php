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
<body <?php body_class('bg-white text-[#003745]'); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-40 border-b border-[#003745]/10 bg-[#FF2030]">
	<div class="mx-auto max-w-6xl px-6 py-2 md:py-3">
		<div class="grid grid-cols-[1fr_auto_1fr] items-center gap-3 md:grid-cols-[auto_1fr_auto]">
			<!-- Left (desktop): logo -->
			<div class="hidden md:flex md:items-center">
				<?php
				if (function_exists('popbag_render_site_logo')) {
					popbag_render_site_logo('', 'h-12 w-auto lg:h-14');
				}
				?>
			</div>

			<!-- Center: mobile logo / desktop menu -->
			<div class="min-w-0 justify-self-center md:justify-self-stretch">
				<div class="md:hidden">
					<?php
					if (function_exists('popbag_render_site_logo')) {
						popbag_render_site_logo('justify-self-center', 'h-12 w-auto');
					}
					?>
				</div>
				<nav class="popbag-primary-nav hidden md:flex md:items-center md:justify-center">
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm font-semibold uppercase tracking-[0.12em]',
						'fallback_cb'    => false,
					]);
					?>
				</nav>
			</div>

			<!-- Right: CTAs + (mobile) hamburger -->
			<?php $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart'); ?>
			<?php
			$myaccount_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
			$myaccount_url = $myaccount_url ? $myaccount_url : home_url('/');
			?>
			<div class="flex items-center justify-self-end gap-2 md:gap-3">
				<?php if (is_user_logged_in()) : ?>
					<details class="relative">
						<summary class="list-none">
							<span class="flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border border-[#003745]/15 bg-white text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/30 hover:shadow-sm" aria-label="<?php echo esc_attr__('Account', 'popbag-minimal'); ?>">
								<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 1 0-16 0"></path>
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z"></path>
								</svg>
								<span class="sr-only"><?php esc_html_e('Open account menu', 'popbag-minimal'); ?></span>
							</span>
						</summary>

						<div class="absolute right-0 mt-2 w-64 overflow-hidden rounded-[16px] border border-[#003745]/10 bg-white shadow-lg">
							<div class="border-b border-[#003745]/10 p-4">
								<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Account', 'popbag-minimal'); ?></p>
								<p class="mt-1 text-sm font-black text-[#003745]">
									<?php echo esc_html(wp_get_current_user()->display_name); ?>
								</p>
							</div>
							<div class="p-2">
								<?php if (function_exists('wc_get_account_endpoint_url')) : ?>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#003745] hover:bg-[#003745]/5" href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>"><?php esc_html_e('Dashboard', 'woocommerce'); ?></a>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#003745] hover:bg-[#003745]/5" href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"><?php esc_html_e('Orders', 'woocommerce'); ?></a>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#003745] hover:bg-[#003745]/5" href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>"><?php esc_html_e('Addresses', 'woocommerce'); ?></a>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#003745] hover:bg-[#003745]/5" href="<?php echo esc_url(wc_get_account_endpoint_url('payment-methods')); ?>"><?php esc_html_e('Payment methods', 'woocommerce'); ?></a>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#003745] hover:bg-[#003745]/5" href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>"><?php esc_html_e('Account details', 'woocommerce'); ?></a>
									<div class="my-1 border-t border-[#003745]/10"></div>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#FF2030] hover:bg-[#FF2030]/5" href="<?php echo esc_url(function_exists('wc_logout_url') ? wc_logout_url() : wp_logout_url($myaccount_url)); ?>"><?php esc_html_e('Log out', 'woocommerce'); ?></a>
								<?php else : ?>
									<a class="block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#003745] hover:bg-[#003745]/5" href="<?php echo esc_url($myaccount_url); ?>"><?php esc_html_e('My account', 'woocommerce'); ?></a>
									<a class="mt-1 block rounded-[14px] px-3 py-2 text-sm font-semibold text-[#FF2030] hover:bg-[#FF2030]/5" href="<?php echo esc_url(wp_logout_url($myaccount_url)); ?>"><?php esc_html_e('Log out', 'woocommerce'); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</details>
				<?php else : ?>
					<a class="<?php echo esc_attr(popbag_button_classes('outline', 'sm', 'h-10')); ?>" href="<?php echo esc_url($myaccount_url); ?>">
						<?php esc_html_e('Login', 'woocommerce'); ?>
					</a>
					<a class="<?php echo esc_attr(popbag_button_classes('secondary', 'sm', 'h-10')); ?>" href="<?php echo esc_url($myaccount_url); ?>">
						<?php esc_html_e('Register', 'woocommerce'); ?>
					</a>
				<?php endif; ?>

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

				<button
					type="button"
					class="md:hidden flex h-10 w-10 items-center justify-center rounded-full border border-[#003745]/15 bg-white text-[#003745] transition hover:-translate-y-px hover:border-[#003745]/30 hover:shadow-sm"
					aria-label="<?php echo esc_attr__('Open menu', 'popbag-minimal'); ?>"
					aria-expanded="false"
					aria-controls="popbag-mobile-menu"
					data-popbag-menu-toggle
				>
					<svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"></path>
					</svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Mobile menu overlay -->
	<div class="md:hidden">
		<div class="fixed inset-0 z-50 hidden bg-black/40" data-popbag-menu-backdrop></div>
		<div
			id="popbag-mobile-menu"
			class="fixed right-0 top-0 z-50 hidden h-full w-[85vw] max-w-sm border-l border-[#003745]/10 bg-white shadow-2xl"
			role="dialog"
			aria-modal="true"
			aria-label="<?php echo esc_attr__('Menu', 'popbag-minimal'); ?>"
			data-popbag-menu-panel
		>
			<div class="flex items-center justify-between border-b border-[#003745]/10 px-5 py-4">
				<span class="text-sm font-extrabold uppercase tracking-[0.12em] text-[#003745]"><?php echo esc_html(get_bloginfo('name')); ?></span>
				<button
					type="button"
					class="flex h-10 w-10 items-center justify-center rounded-full border border-[#003745]/15 bg-white text-[#003745]"
					aria-label="<?php echo esc_attr__('Close menu', 'popbag-minimal'); ?>"
					aria-expanded="true"
					data-popbag-menu-toggle
				>
					<svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"></path>
					</svg>
				</button>
			</div>
			<nav class="popbag-mobile-nav px-5 py-4">
				<div class="mb-4">
					<?php if (is_user_logged_in()) : ?>
						<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Account', 'popbag-minimal'); ?></p>
						<p class="mt-1 text-sm font-black text-[#003745]"><?php echo esc_html(wp_get_current_user()->display_name); ?></p>

						<div class="mt-3 grid gap-2">
							<?php if (function_exists('wc_get_account_endpoint_url')) : ?>
								<a class="rounded-[14px] border border-[#003745]/10 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>"><?php esc_html_e('Dashboard', 'woocommerce'); ?></a>
								<a class="rounded-[14px] border border-[#003745]/10 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"><?php esc_html_e('Orders', 'woocommerce'); ?></a>
								<a class="rounded-[14px] border border-[#003745]/10 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>"><?php esc_html_e('Addresses', 'woocommerce'); ?></a>
								<a class="rounded-[14px] border border-[#003745]/10 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_account_endpoint_url('payment-methods')); ?>"><?php esc_html_e('Payment methods', 'woocommerce'); ?></a>
								<a class="rounded-[14px] border border-[#003745]/10 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>"><?php esc_html_e('Account details', 'woocommerce'); ?></a>
								<a class="rounded-[14px] border border-[#FF2030]/20 bg-[#FF2030]/5 px-4 py-2 text-sm font-semibold text-[#FF2030]" href="<?php echo esc_url(function_exists('wc_logout_url') ? wc_logout_url() : wp_logout_url($myaccount_url)); ?>"><?php esc_html_e('Log out', 'woocommerce'); ?></a>
							<?php else : ?>
								<a class="rounded-[14px] border border-[#003745]/10 bg-white px-4 py-2 text-sm font-semibold text-[#003745]" href="<?php echo esc_url($myaccount_url); ?>"><?php esc_html_e('My account', 'woocommerce'); ?></a>
								<a class="rounded-[14px] border border-[#FF2030]/20 bg-[#FF2030]/5 px-4 py-2 text-sm font-semibold text-[#FF2030]" href="<?php echo esc_url(wp_logout_url($myaccount_url)); ?>"><?php esc_html_e('Log out', 'woocommerce'); ?></a>
							<?php endif; ?>
						</div>
					<?php else : ?>
						<div class="grid grid-cols-2 gap-2">
							<a class="<?php echo esc_attr(popbag_button_classes('outline', 'sm', 'w-full')); ?>" href="<?php echo esc_url($myaccount_url); ?>"><?php esc_html_e('Login', 'woocommerce'); ?></a>
							<a class="<?php echo esc_attr(popbag_button_classes('secondary', 'sm', 'w-full')); ?>" href="<?php echo esc_url($myaccount_url); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></a>
						</div>
					<?php endif; ?>
				</div>
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'flex flex-col gap-3 text-base font-semibold uppercase tracking-[0.12em]',
					'fallback_cb'    => false,
				]);
				?>
			</nav>
		</div>
	</div>
</header>

