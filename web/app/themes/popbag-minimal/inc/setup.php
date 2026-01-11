<?php
/**
 * Theme setup (supports, menus, i18n).
 */
if (!defined('ABSPATH')) {
	exit;
}

add_action('after_setup_theme', static function (): void {
	load_theme_textdomain('popbag-minimal', get_template_directory() . '/languages');

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('custom-logo', [
		'height'      => 80,
		'width'       => 260,
		'flex-height' => true,
		'flex-width'  => true,
	]);

	add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('align-wide');
	add_theme_support('responsive-embeds');

	// WooCommerce core support is enabled in inc/woocommerce.php (so it can be toggled safely).

	register_nav_menus([
		'primary' => __('Primary Menu', 'popbag-minimal'),
		'footer'  => __('Footer Menu', 'popbag-minimal'),
	]);
});



