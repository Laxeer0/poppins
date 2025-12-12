<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme bootstrap.
 */
function poppins_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support(
        'custom-logo',
        [
            'height'      => 80,
            'width'       => 200,
            'flex-width'  => true,
            'flex-height' => true,
        ]
    );

    register_nav_menus(
        [
            'primary' => __('Menu principale', 'poppins'),
            'footer'  => __('Menu footer', 'poppins'),
        ]
    );

    add_image_size('poppins-hero', 1920, 1080, true);
}
add_action('after_setup_theme', 'poppins_setup');

/**
 * Aggiunge gli asset principali.
 */
function poppins_enqueue_assets(): void
{
    wp_enqueue_style(
        'poppins-theme',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'poppins_enqueue_assets');

/**
 * Helper: verifica se WooCommerce è attivo.
 */
function poppins_has_woocommerce(): bool
{
    return class_exists('WooCommerce');
}

/**
 * Helper: URL della pagina shop.
 */
function poppins_get_shop_url(): string
{
    if (function_exists('wc_get_page_permalink')) {
        return wc_get_page_permalink('shop');
    }

    return home_url('/');
}

/**
 * Conteggio prodotti nel carrello.
 */
function poppins_get_cart_count(): int
{
    if (!poppins_has_woocommerce()) {
        return 0;
    }

    $cart = function_exists('WC') ? WC()->cart : null;

    return $cart ? (int) $cart->get_cart_contents_count() : 0;
}

/**
 * Fallback del menu per quando non è ancora configurato.
 */
function poppins_menu_fallback(): void
{
    echo '<ul><li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Configura il menu', 'poppins') . '</a></li></ul>';
}

/**
 * Form newsletter demo (non invia dati).
 */
function poppins_render_newsletter_form(): void
{
    ?>
    <form class="newsletter-form" action="#" method="post">
        <label class="screen-reader-text" for="newsletter-email"><?php esc_html_e('Email', 'poppins'); ?></label>
        <input id="newsletter-email" type="email" name="newsletter-email" placeholder="<?php esc_attr_e('La tua email', 'poppins'); ?>" required />
        <button class="btn btn-primary" type="submit"><?php esc_html_e('Iscrivimi', 'poppins'); ?></button>
    </form>
    <?php
}
