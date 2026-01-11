<?php
/**
 * Theme bootstrap (Bedrock theme).
 *
 * This theme keeps logic split into small modules in /inc.
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Load theme modules.
 *
 * IMPORTANT: keep functions unique (avoid re-declaring). All feature code lives in /inc.
 */
$popbag_includes = [
	'inc/setup.php',
	'inc/helpers.php',
	'inc/cache.php',
	'inc/woocommerce.php',
	'inc/bag.php',
	'inc/assets.php',
	'inc/shortcodes.php',
	'inc/blocks.php',
	'inc/customizer.php',
	'inc/onboarding.php',
];

foreach ($popbag_includes as $rel) {
	$path = get_theme_file_path($rel);
	if (file_exists($path)) {
		require_once $path;
	}
}
