<?php
/**
 * WooCommerce integration (supports + helpers + small UX/styling hooks).
 *
 * We prefer hooks over template overrides; templates in /woocommerce are used only where markup must match the mockup.
 */
if (!defined('ABSPATH')) {
	exit;
}

add_action('after_setup_theme', static function (): void {
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
});

// Disable default Woo styles (Tailwind handles styling via classes / overrides).
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Minimal product helpers used by mockup templates.
 */
function popbag_has_woocommerce(): bool {
	return function_exists('wc_get_products') || class_exists('WooCommerce');
}

function popbag_get_new_arrivals(int $limit = 6) {
	if (!popbag_has_woocommerce()) {
		return [];
	}

	return popbag_cache_get(
		'new_arrivals_' . $limit,
		1800,
		static function () use ($limit) {
			return wc_get_products([
				'status'   => 'publish',
				'orderby'  => 'date',
				'order'    => 'DESC',
				'limit'    => $limit,
				'paginate' => false,
			]);
		}
	);
}

function popbag_get_best_sellers(int $limit = 6) {
	if (!popbag_has_woocommerce()) {
		return [];
	}

	return popbag_cache_get(
		'best_sellers_' . $limit,
		3600,
		static function () use ($limit) {
			return wc_get_products([
				'status'     => 'publish',
				'limit'      => $limit,
				'paginate'   => false,
				'meta_key'   => 'total_sales',
				'orderby'    => 'meta_value_num',
				'order'      => 'DESC',
				'visibility' => 'visible',
			]);
		}
	);
}

function popbag_get_products_by_category_slug(string $slug, int $limit = 12) {
	if (!popbag_has_woocommerce()) {
		return [];
	}

	$slug = sanitize_title($slug);
	if ('' === $slug) {
		return [];
	}

	return popbag_cache_get(
		'products_cat_' . $slug . '_' . $limit,
		1800,
		static function () use ($slug, $limit) {
			return wc_get_products([
				'status'   => 'publish',
				'limit'    => $limit,
				'paginate' => false,
				'category' => [$slug],
			]);
		}
	);
}

function popbag_get_product_categories_cached(array $args = []) {
	$defaults = [
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'number'     => 6,
	];

	$merged = wp_parse_args($args, $defaults);

	return popbag_cache_get(
		'product_categories_' . md5(wp_json_encode($merged)),
		21600,
		static function () use ($merged) {
			return get_terms($merged);
		}
	);
}

/**
 * Tailwind-friendly classes for Woo form fields.
 */
add_filter('woocommerce_form_field_args', static function (array $args, string $key, $value): array {
	// Ensure labels exist for accessibility.
	$args['label_class'] = array_merge((array) ($args['label_class'] ?? []), ['block', 'text-sm', 'font-semibold', 'text-[#003745]']);
	$args['input_class'] = array_merge((array) ($args['input_class'] ?? []), ['mt-1', 'w-full', 'rounded-[14px]', 'border', 'border-[#003745]/15', 'bg-white', 'px-4', 'py-3', 'text-[#003745]', 'placeholder-[#1F525E]/60', 'focus:border-[#003745]/40', 'focus:outline-none', 'focus:ring-2', 'focus:ring-[#FF2030]/20']);
	$args['class']       = array_merge((array) ($args['class'] ?? []), ['popbag-wc-field']);
	return $args;
}, 10, 3);

/**
 * Tailwind-friendly classes for "Add to cart" buttons in product loops.
 */
add_filter('woocommerce_loop_add_to_cart_args', static function (array $args, WC_Product $product): array {
	$classes = $args['class'] ?? 'button';

	$theme_btn = function_exists('popbag_button_classes')
		? popbag_button_classes('secondary', 'md', 'w-full hover:bg-[#FF2030]')
		: 'w-full rounded-full bg-[#003745] px-5 py-3 text-center text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md';

	$args['class'] = trim($classes . ' ' . $theme_btn);
	$args['attributes'] = array_merge(
		(array) ($args['attributes'] ?? []),
		[
			'aria-label' => sprintf(
				/* translators: %s: product name */
				__('Add “%s” to your cart', 'popbag-minimal'),
				$product->get_name()
			),
		]
	);

	return $args;
}, 10, 2);

/**
 * Provide a consistent container on Woo pages when templates aren't overridden.
 * (We only wrap, we do not change core behavior.)
 */
add_action('woocommerce_before_main_content', static function (): void {
	if (is_admin()) {
		return;
	}
	echo '<main class="bg-white"><div class="mx-auto max-w-6xl px-6 py-12">';
	woocommerce_output_all_notices();
}, 1);

add_action('woocommerce_after_main_content', static function (): void {
	if (is_admin()) {
		return;
	}
	echo '</div></main>';
}, 99);

/**
 * WooCommerce "Coming soon" page (theme-styled).
 *
 * WooCommerce stores the setting in:
 * - woocommerce_coming_soon: yes|no
 * - woocommerce_store_pages_only: yes|no
 */
function popbag_is_woocommerce_coming_soon_enabled(): bool {
	return 'yes' === (string) get_option('woocommerce_coming_soon', 'no');
}

function popbag_is_woocommerce_request(): bool {
	if (!function_exists('is_woocommerce')) {
		return false;
	}

	return (bool) (
		is_woocommerce()
		|| (function_exists('is_cart') && is_cart())
		|| (function_exists('is_checkout') && is_checkout())
		|| (function_exists('is_account_page') && is_account_page())
	);
}

function popbag_current_user_can_bypass_coming_soon(): bool {
	// Match typical Woo/admin expectations: admins/shop managers can view the site.
	return is_user_logged_in()
		&& (current_user_can('manage_woocommerce') || current_user_can('manage_options'));
}

add_action('template_redirect', static function (): void {
	if (!popbag_is_woocommerce_coming_soon_enabled()) {
		return;
	}

	// Never affect admin, cron, or AJAX/REST endpoints.
	if (is_admin() || (defined('DOING_CRON') && DOING_CRON)) {
		return;
	}
	if ((defined('REST_REQUEST') && REST_REQUEST) || str_starts_with((string) ($_SERVER['REQUEST_URI'] ?? ''), '/wp-json/')) {
		return;
	}
	if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}
	// WooCommerce AJAX endpoints define WC_DOING_AJAX and/or pass wc-ajax query var.
	$wc_doing_ajax = defined('WC_DOING_AJAX') ? (bool) constant('WC_DOING_AJAX') : false;
	if ($wc_doing_ajax || isset($_GET['wc-ajax'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	// Allow privileged users to bypass.
	if (popbag_current_user_can_bypass_coming_soon()) {
		return;
	}

	// If WooCommerce is configured to hide store pages only, intercept only Woo routes.
	$store_pages_only = 'yes' === (string) get_option('woocommerce_store_pages_only', 'no');
	if ($store_pages_only && !popbag_is_woocommerce_request()) {
		return;
	}

	// Prevent admin bar from shifting layout for logged-in non-privileged users.
	add_filter('show_admin_bar', '__return_false', 999);

	if (!defined('POPBAG_WC_COMING_SOON')) {
		define('POPBAG_WC_COMING_SOON', true);
	}

	$template = get_theme_file_path('template-parts/coming-soon.php');
	if (file_exists($template)) {
		nocache_headers();
		require $template;
		exit;
	}
}, 0);


