<?php
/**
 * Header template.
 *
 * @package Poppins
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container site-header__inner">
        <div class="branding">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    POPPINS
                    <span>atelier</span>
                </a>
                <?php
            }
?>
        </div>

        <nav class="primary-nav" aria-label="<?php esc_attr_e('Menu principale', 'poppins'); ?>">
            <?php
if (has_nav_menu('primary')) {
    wp_nav_menu(
        [
            'theme_location' => 'primary',
            'container'      => false,
            'fallback_cb'    => 'poppins_menu_fallback',
        ],
    );
} else {
    poppins_menu_fallback();
}
?>
        </nav>

        <div class="header-actions">
            <a class="btn btn-outline" href="<?php echo esc_url(poppins_get_shop_url()); ?>">
                <?php esc_html_e('Collezione', 'poppins'); ?>
            </a>
            <?php if (poppins_has_woocommerce()) : ?>
                <a class="cart-link" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    <?php esc_html_e('Bag', 'poppins'); ?>
                    <span class="cart-count"><?php echo esc_html(poppins_get_cart_count()); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
