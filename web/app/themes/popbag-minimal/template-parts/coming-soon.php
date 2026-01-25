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
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-W76ZNNG3');</script>
	<!-- End Google Tag Manager -->
	<?php wp_head(); ?>
</head>
<body <?php body_class('popbag-coming-soon'); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W76ZNNG3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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

