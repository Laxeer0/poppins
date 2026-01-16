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

/**
 * Utility: merge class strings (Tailwind-friendly).
 *
 * Accepts strings and arrays (nested). Removes empties and trims.
 */
function popbag_classnames(...$parts): string {
	$out = [];
	$stack = $parts;

	while (!empty($stack)) {
		$part = array_shift($stack);
		if (is_array($part)) {
			$stack = array_merge($part, $stack);
			continue;
		}
		if (!is_string($part)) {
			continue;
		}
		$part = trim($part);
		if ($part !== '') {
			$out[] = $part;
		}
	}

	return trim(implode(' ', $out));
}

/**
 * UI: consistent button classes across templates.
 */
function popbag_button_classes(string $variant = 'primary', string $size = 'md', string $extra = ''): string {
	$base = 'inline-flex items-center justify-center rounded-full font-bold uppercase tracking-[0.18em] transition hover:-translate-y-px';

	$size_classes = match ($size) {
		'sm' => 'px-4 py-2 text-xs',
		'lg' => 'px-7 py-4 text-sm',
		default => 'px-6 py-3 text-sm',
	};

	$variant_classes = match ($variant) {
		'secondary' => 'bg-[#003745] text-white hover:shadow-md',
		'outline'   => 'border border-[#003745]/15 bg-white text-[#003745] hover:shadow-sm',
		'ghost'     => 'bg-transparent text-[#003745] hover:bg-[#003745]/5',
		default     => 'bg-[#FF2030] text-white hover:shadow-md',
	};

	return popbag_classnames($base, $size_classes, $variant_classes, $extra);
}



