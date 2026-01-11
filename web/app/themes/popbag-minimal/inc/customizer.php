<?php
/**
 * Customizer: global header/footer options (CTA, contacts, socials).
 *
 * Keeps the theme dependency-free (no ACF) while meeting “configurabile” requirement.
 */
if (!defined('ABSPATH')) {
	exit;
}

add_action('customize_register', static function (WP_Customize_Manager $wp_customize): void {
	$wp_customize->add_section('popbag_theme_options', [
		'title'       => __('POP BAG Options', 'popbag-minimal'),
		'description' => __('Header/Footer global settings.', 'popbag-minimal'),
		'priority'    => 160,
	]);

	// Header CTA.
	$wp_customize->add_setting('popbag_header_cta_label', [
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	]);
	$wp_customize->add_control('popbag_header_cta_label', [
		'section' => 'popbag_theme_options',
		'label'   => __('Header CTA label', 'popbag-minimal'),
		'type'    => 'text',
	]);

	$wp_customize->add_setting('popbag_header_cta_url', [
		'type'              => 'theme_mod',
		'sanitize_callback' => 'esc_url_raw',
		'default'           => '',
	]);
	$wp_customize->add_control('popbag_header_cta_url', [
		'section' => 'popbag_theme_options',
		'label'   => __('Header CTA URL', 'popbag-minimal'),
		'type'    => 'url',
	]);

	// Footer.
	$wp_customize->add_setting('popbag_footer_title', [
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => 'Pop Bag',
	]);
	$wp_customize->add_control('popbag_footer_title', [
		'section' => 'popbag_theme_options',
		'label'   => __('Footer title', 'popbag-minimal'),
		'type'    => 'text',
	]);

	$wp_customize->add_setting('popbag_footer_text', [
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_textarea_field',
		'default'           => 'Minimal premium essentials for your style.',
	]);
	$wp_customize->add_control('popbag_footer_text', [
		'section' => 'popbag_theme_options',
		'label'   => __('Footer text', 'popbag-minimal'),
		'type'    => 'textarea',
	]);

	// Contacts.
	$wp_customize->add_setting('popbag_contact_email', [
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_email',
		'default'           => '',
	]);
	$wp_customize->add_control('popbag_contact_email', [
		'section' => 'popbag_theme_options',
		'label'   => __('Contact email', 'popbag-minimal'),
		'type'    => 'email',
	]);

	$wp_customize->add_setting('popbag_contact_phone', [
		'type'              => 'theme_mod',
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '',
	]);
	$wp_customize->add_control('popbag_contact_phone', [
		'section' => 'popbag_theme_options',
		'label'   => __('Contact phone', 'popbag-minimal'),
		'type'    => 'text',
	]);

	// Socials.
	foreach ([
		'instagram' => __('Instagram URL', 'popbag-minimal'),
		'facebook'  => __('Facebook URL', 'popbag-minimal'),
		'tiktok'    => __('TikTok URL', 'popbag-minimal'),
	] as $key => $label) {
		$setting = 'popbag_social_' . $key;
		$wp_customize->add_setting($setting, [
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '',
		]);
		$wp_customize->add_control($setting, [
			'section' => 'popbag_theme_options',
			'label'   => $label,
			'type'    => 'url',
		]);
	}
});



