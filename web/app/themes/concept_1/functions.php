<?php
/**
 * POP BAG Theme functions
 */

if (!defined('ABSPATH')) {
    exit;
}

define('POPBAG_VERSION', '1.0.0');
define('POPBAG_CACHE_OPTION', 'popbag_cache_v');

/**
 * Theme setup.
 */
function popbag_theme_setup(): void
{
    load_theme_textdomain('popbag', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Primary Menu', 'popbag'),
        'footer'  => __('Footer Menu', 'popbag'),
    ]);

    add_image_size('popbag-card', 800, 800, true);
}
add_action('after_setup_theme', 'popbag_theme_setup');

/**
 * Enqueue styles and scripts.
 */
function popbag_enqueue_assets(): void
{
    $theme     = wp_get_theme();
    $style_uri = get_stylesheet_directory_uri() . '/public/app.css';
    $style_dir = get_stylesheet_directory() . '/public/app.css';
    $version   = file_exists($style_dir) ? (string) filemtime($style_dir) : $theme->get('Version');

    wp_enqueue_style('popbag-app', $style_uri, [], $version);

    // Simple mobile nav toggle + cart fragment hook target
    $inline_js = <<<'JS'
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.querySelector('[data-popbag-nav-toggle]');
        const menus = document.querySelectorAll('[data-popbag-nav-mobile]');
        if (toggle && menus.length) {
            toggle.addEventListener('click', () => {
                menus.forEach(menu => menu.classList.toggle('hidden'));
            });
        }
    });
    JS;
    wp_add_inline_script('jquery-core', $inline_js); // use existing bundled handle
}
add_action('wp_enqueue_scripts', 'popbag_enqueue_assets');

/**
 * WooCommerce cart count fragment for AJAX updates.
 */
function popbag_cart_count_fragment(array $fragments): array
{
    if (!function_exists('WC') || !WC()->cart) {
        return $fragments;
    }

    $count = WC()->cart->get_cart_contents_count();
    $html  = '<span id="popbag-cart-count" class="ml-2 inline-flex h-7 min-w-[28px] items-center justify-center rounded-full bg-[#FF2030] px-2 text-xs font-black text-white">' . esc_html($count) . '</span>';
    $fragments['#popbag-cart-count'] = $html;

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'popbag_cart_count_fragment');

/**
 * Cache helpers.
 */
function popbag_cache_version(): int
{
    return (int) get_option(POPBAG_CACHE_OPTION, 1);
}

function popbag_cache_key(string $key): string
{
    $version = popbag_cache_version();
    $safe    = sanitize_key($key);
    return 'popbag_v' . $version . '_' . $safe;
}

function popbag_cache_bump_version(): void
{
    $version = popbag_cache_version() + 1;
    update_option(POPBAG_CACHE_OPTION, $version, false);
}

/**
 * Retrieve cached data or compute via callback.
 */
function popbag_cache_get(string $key, int $ttl, callable $callback)
{
    $transient_key = popbag_cache_key($key);
    $cached        = get_transient($transient_key);

    if (false !== $cached) {
        return $cached;
    }

    $data = call_user_func($callback);
    set_transient($transient_key, $data, $ttl);

    return $data;
}

/**
 * Cache invalidation hooks.
 */
function popbag_cache_on_deleted_post(int $post_id): void
{
    if ('product' === get_post_type($post_id)) {
        popbag_cache_bump_version();
    }
}

function popbag_cache_on_transition(string $new_status, string $old_status, WP_Post $post): void
{
    if ('product' === $post->post_type && $new_status !== $old_status) {
        popbag_cache_bump_version();
    }
}

function popbag_cache_on_term_change(int $term_id, int $tt_id, string $taxonomy): void
{
    if ('product_cat' === $taxonomy) {
        popbag_cache_bump_version();
    }
}

function popbag_register_cache_invalidation_hooks(): void
{
    add_action('save_post_product', 'popbag_cache_bump_version');
    add_action('deleted_post', 'popbag_cache_on_deleted_post');
    add_action('transition_post_status', 'popbag_cache_on_transition', 10, 3);
    add_action('woocommerce_update_product', 'popbag_cache_bump_version');
    add_action('woocommerce_product_set_stock', 'popbag_cache_bump_version');
    add_action('edited_terms', 'popbag_cache_on_term_change', 10, 3);
    add_action('created_term', 'popbag_cache_on_term_change', 10, 3);
    add_action('delete_term', 'popbag_cache_on_term_change', 10, 3);
}
add_action('init', 'popbag_register_cache_invalidation_hooks');

/**
 * Data providers with caching.
 */
function popbag_get_best_seller_ids(int $limit = 8): array
{
    if (!function_exists('wc_get_products')) {
        return [];
    }

    return popbag_cache_get('best_sellers', HOUR_IN_SECONDS, static function () use ($limit): array {
        return wc_get_products([
            'status'   => 'publish',
            'limit'    => $limit,
            'orderby'  => 'meta_value_num',
            'order'    => 'DESC',
            'meta_key' => 'total_sales',
            'return'   => 'ids',
        ]);
    });
}

function popbag_get_new_arrival_ids(int $limit = 8): array
{
    if (!function_exists('wc_get_products')) {
        return [];
    }

    return popbag_cache_get('new_arrivals', 30 * MINUTE_IN_SECONDS, static function () use ($limit): array {
        return wc_get_products([
            'status'  => 'publish',
            'limit'   => $limit,
            'orderby' => 'date',
            'order'   => 'DESC',
            'return'  => 'ids',
        ]);
    });
}

function popbag_get_primary_categories(int $limit = 6): array
{
    if (!taxonomy_exists('product_cat')) {
        return [];
    }

    return popbag_cache_get('primary_categories', 12 * HOUR_IN_SECONDS, static function () use ($limit): array {
        $terms = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'number'     => $limit,
            'orderby'    => 'count',
            'order'      => 'DESC',
        ]);

        return is_array($terms) ? $terms : [];
    });
}

function popbag_build_product_query(array $ids): WP_Query
{
    $ids = array_map('absint', array_filter($ids));

    return new WP_Query([
        'post_type'           => 'product',
        'posts_per_page'      => count($ids),
        'post__in'            => $ids,
        'orderby'             => 'post__in',
        'ignore_sticky_posts' => true,
    ]);
}

/**
 * Disable default Woo styles to lean on Tailwind.
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Helper: determine badge tags.
 */
function popbag_get_product_badges(WC_Product $product): array
{
    $badges = [];

    if ($product->is_featured()) {
        $badges[] = 'DROP';
    }

    $created = $product->get_date_created();
    if ($created && $created->getTimestamp() >= strtotime('-30 days')) {
        $badges[] = 'NEW';
    }

    if ($product->managing_stock() && $product->get_stock_quantity() !== null && $product->get_stock_quantity() <= 5) {
        $badges[] = 'LIMITED';
    } elseif (!$product->managing_stock() && $product->is_on_sale()) {
        $badges[] = 'LIMITED';
    }

    return array_unique($badges);
}

