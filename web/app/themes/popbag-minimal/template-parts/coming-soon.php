<?php
if (!defined('ABSPATH')) {
	exit;
}

$logo_html = '';

if (function_exists('has_custom_logo') && has_custom_logo() && function_exists('get_custom_logo')) {
	// get_custom_logo() returns full markup with link.
	$logo_html = (string) get_custom_logo();
} else {
	$logo_src = get_theme_file_uri('assets/images/logo-orizzontale.svg');
	$logo_html = sprintf(
		'<img class="popbag-coming-soon__logo-img" src="%s" alt="%s" width="320" height="98" loading="eager" decoding="async" />',
		esc_url($logo_src),
		esc_attr(get_bloginfo('name'))
	);
}

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class('popbag-coming-soon'); ?>>
<?php wp_body_open(); ?>

<main class="popbag-coming-soon__wrap" role="main">
	<div class="popbag-coming-soon__inner">
		<div class="popbag-coming-soon__logo">
			<?php echo $logo_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<p class="popbag-coming-soon__text">
			<?php echo esc_html__('Presto online', 'popbag-minimal'); ?>
		</p>
	</div>
</main>

<?php wp_footer(); ?>
</body>
</html>

