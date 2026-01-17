<?php
if (!defined('ABSPATH')) {
	exit;
}

$title = (string) get_theme_mod('popbag_footer_title', get_bloginfo('name'));
$text  = (string) get_theme_mod('popbag_footer_text', get_bloginfo('description'));
$email = (string) get_theme_mod('popbag_contact_email', '');
$phone = (string) get_theme_mod('popbag_contact_phone', '');

$socials = array_filter([
	(string) get_theme_mod('popbag_social_instagram', ''),
	(string) get_theme_mod('popbag_social_facebook', ''),
	(string) get_theme_mod('popbag_social_tiktok', ''),
]);

$shop_url     = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
$account_url  = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
$privacy_url  = function_exists('get_privacy_policy_url') ? get_privacy_policy_url() : '';
$bags_url     = post_type_exists('poppins_bag') ? (string) get_post_type_archive_link('poppins_bag') : '';
$contact_page = get_page_by_path('contatti') ?: get_page_by_path('contatto');
$contact_url  = $contact_page instanceof WP_Post ? get_permalink($contact_page) : '';

$legal_name = (string) get_theme_mod('popbag_business_legal_name', '');
$vat        = (string) get_theme_mod('popbag_business_vat', '');
$street     = (string) get_theme_mod('popbag_business_street', '');
$city       = (string) get_theme_mod('popbag_business_city', '');
$region     = (string) get_theme_mod('popbag_business_region', '');
$postal     = (string) get_theme_mod('popbag_business_postal', '');
$country    = (string) get_theme_mod('popbag_business_country', '');

$logo_url = '';
$custom_logo_id = (int) get_theme_mod('custom_logo');
if ($custom_logo_id) {
	$maybe = wp_get_attachment_image_url($custom_logo_id, 'full');
	if ($maybe) {
		$logo_url = (string) $maybe;
	}
}

$schema = [
	'@context' => 'https://schema.org',
	'@type'    => 'Organization',
	'name'     => $legal_name ? $legal_name : ($title ?: get_bloginfo('name')),
	'url'      => home_url('/'),
];

if ($logo_url) {
	$schema['logo'] = $logo_url;
}

if (!empty($socials)) {
	$schema['sameAs'] = array_values($socials);
}

$contact_points = [];
if ($email || $phone) {
	$cp = [
		'@type'       => 'ContactPoint',
		'contactType' => 'customer support',
	];
	if ($phone) {
		$cp['telephone'] = $phone;
	}
	if ($email) {
		$cp['email'] = $email;
	}
	$contact_points[] = $cp;
}
if (!empty($contact_points)) {
	$schema['contactPoint'] = $contact_points;
}

if ($street || $city || $postal || $country) {
	$addr = [
		'@type' => 'PostalAddress',
	];
	if ($street) {
		$addr['streetAddress'] = $street;
	}
	if ($city) {
		$addr['addressLocality'] = $city;
	}
	if ($region) {
		$addr['addressRegion'] = $region;
	}
	if ($postal) {
		$addr['postalCode'] = $postal;
	}
	if ($country) {
		$addr['addressCountry'] = $country;
	}
	$schema['address'] = $addr;
}
?>

<footer class="border-t border-[#003745]/10 bg-white" role="contentinfo">
	<div class="mx-auto max-w-6xl px-6 py-12">
		<div class="grid gap-10 md:grid-cols-4">
			<div class="md:col-span-2">
				<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php echo esc_html($title ?: get_bloginfo('name')); ?></p>
				<p class="mt-3 max-w-xl text-sm text-[#003745]">
					<?php echo esc_html($text ?: get_bloginfo('description')); ?>
				</p>

				<?php if ($email || $phone || $vat) : ?>
					<div class="mt-5 space-y-2 text-sm text-[#003745]">
						<?php if ($email) : ?>
							<p class="m-0">
								<span class="font-semibold"><?php esc_html_e('Email', 'popbag-minimal'); ?>:</span>
								<a class="underline decoration-[#FF2030] decoration-2 underline-offset-4" href="<?php echo esc_url('mailto:' . $email); ?>"><?php echo esc_html($email); ?></a>
							</p>
						<?php endif; ?>
						<?php if ($phone) : ?>
							<p class="m-0">
								<span class="font-semibold"><?php esc_html_e('Telefono', 'popbag-minimal'); ?>:</span>
								<a class="underline decoration-[#FF2030] decoration-2 underline-offset-4" href="<?php echo esc_url('tel:' . preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
							</p>
						<?php endif; ?>
						<?php if ($vat) : ?>
							<p class="m-0">
								<span class="font-semibold"><?php esc_html_e('P.IVA', 'popbag-minimal'); ?>:</span>
								<?php echo esc_html($vat); ?>
							</p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($socials)) : ?>
					<div class="mt-6 flex flex-wrap items-center gap-3">
						<?php foreach ($socials as $url) : ?>
							<a class="inline-flex items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:shadow-sm" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
								<?php echo esc_html(parse_url($url, PHP_URL_HOST) ?: 'Social'); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Shop', 'popbag-minimal'); ?></p>
				<ul class="mt-4 space-y-2 text-sm">
					<?php if ($shop_url) : ?><li><a class="font-semibold text-[#003745] hover:underline underline-offset-4" href="<?php echo esc_url($shop_url); ?>"><?php esc_html_e('Tutti i prodotti', 'popbag-minimal'); ?></a></li><?php endif; ?>
					<?php if ($bags_url) : ?><li><a class="font-semibold text-[#003745] hover:underline underline-offset-4" href="<?php echo esc_url($bags_url); ?>"><?php esc_html_e('Le nostre bag', 'popbag-minimal'); ?></a></li><?php endif; ?>
					<?php if ($account_url) : ?><li><a class="font-semibold text-[#003745] hover:underline underline-offset-4" href="<?php echo esc_url($account_url); ?>"><?php esc_html_e('Il mio account', 'popbag-minimal'); ?></a></li><?php endif; ?>
				</ul>
			</div>

			<div>
				<p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#1F525E]"><?php esc_html_e('Info', 'popbag-minimal'); ?></p>
				<ul class="mt-4 space-y-2 text-sm">
					<?php if ($contact_url) : ?><li><a class="font-semibold text-[#003745] hover:underline underline-offset-4" href="<?php echo esc_url($contact_url); ?>"><?php esc_html_e('Contatti', 'popbag-minimal'); ?></a></li><?php endif; ?>
					<?php if ($privacy_url) : ?><li><a class="font-semibold text-[#003745] hover:underline underline-offset-4" href="<?php echo esc_url($privacy_url); ?>"><?php esc_html_e('Privacy Policy', 'popbag-minimal'); ?></a></li><?php endif; ?>
					<?php if (has_nav_menu('footer')) : ?>
						<li class="pt-2">
							<?php
							wp_nav_menu([
								'theme_location' => 'footer',
								'container'      => false,
								'menu_class'     => 'space-y-2',
								'fallback_cb'    => false,
								'depth'          => 1,
							]);
							?>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="mt-12 flex flex-col gap-3 border-t border-[#003745]/10 pt-6 text-xs text-[#1F525E] md:flex-row md:items-center md:justify-between">
			<p class="m-0">
				<?php
				printf(
					/* translators: %1$s: year, %2$s: site name */
					esc_html__('© %1$s %2$s. Tutti i diritti riservati.', 'popbag-minimal'),
					esc_html(date_i18n('Y')),
					esc_html(get_bloginfo('name'))
				);
				?>
			</p>
			<p class="m-0">
				<a class="font-semibold text-[#003745] hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'popbag-minimal'); ?></a>
			</p>
		</div>
	</div>

	<script type="application/ld+json">
		<?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
	</script>
</footer>

<?php wp_footer(); ?>
</body>
</html>



