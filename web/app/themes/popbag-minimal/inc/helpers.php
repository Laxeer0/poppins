<?php
/**
 * Helpers (assets, logo, misc).
 */
if (!defined('ABSPATH')) {
	exit;
}

function popbag_asset_uri(string $relative_path): string {
	$relative_path = ltrim($relative_path, '/');
	return get_theme_file_uri($relative_path);
}

/**
 * Render site logo (navbar).
 *
 * Priority:
 * - Custom Logo (Customizer) if set
 * - Fallback theme SVG in /assets/images/logo-orizzontale.svg
 */
function popbag_render_site_logo(string $wrapper_class = '', string $img_class = 'h-12 w-auto md:h-14 lg:h-16'): void {
	$site_name = get_bloginfo('name');
	$wrapper_class = trim('flex items-center ' . $wrapper_class);

	$custom_logo_id = (int) get_theme_mod('custom_logo');
	if ($custom_logo_id) {
		$src = wp_get_attachment_image_url($custom_logo_id, 'full');
		$alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
		$alt = $alt ? $alt : $site_name;

		if ($src) {
			?>
			<a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo esc_attr($wrapper_class); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
				<img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>" class="<?php echo esc_attr($img_class); ?>" loading="eager" decoding="async" />
			</a>
			<?php
			return;
		}
	}

	$logo_src = popbag_asset_uri('assets/images/logo-orizzontale.svg');
	?>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo esc_attr($wrapper_class); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
		<img src="<?php echo esc_url($logo_src); ?>" alt="<?php echo esc_attr($site_name); ?>" class="<?php echo esc_attr($img_class); ?>" loading="eager" decoding="async" />
	</a>
	<?php
}



