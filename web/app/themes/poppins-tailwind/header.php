<?php
/**
 * Header template.
 *
 * @package PoppinsTailwind
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-stone-50 text-stone-900 antialiased'); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-20 border-b border-stone-200 bg-white/80 backdrop-blur">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
        <div class="text-lg font-semibold tracking-[0.4em]">
            <a href="<?php echo esc_url(home_url('/')); ?>">POPPINS</a>
        </div>

        <nav class="text-sm font-medium uppercase tracking-[0.35em]" aria-label="<?php esc_attr_e('Menu principale', 'poppins-tailwind'); ?>">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(
                    [
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'flex gap-6',
                        'fallback_cb'    => 'poppins_tailwind_menu_fallback',
                    ],
                );
            } else {
                poppins_tailwind_menu_fallback();
            }
?>
        </nav>

        <div class="flex items-center gap-3 text-xs uppercase tracking-[0.3em]">
            <a class="btn btn-outline" href="<?php echo esc_url(home_url('/shop')); ?>">
                <?php esc_html_e('Shop', 'poppins-tailwind'); ?>
            </a>
            <?php if (class_exists('WooCommerce')) : ?>
                <a class="btn btn-primary relative px-4 py-3" href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="<?php esc_attr_e('Vai al carrello', 'poppins-tailwind'); ?>">
                    <span class="sr-only"><?php esc_html_e('Bag', 'poppins-tailwind'); ?></span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 9V7a5 5 0 1 1 10 0v2m-9 4v6m8-6v6M5 9h14l-1.2 11.04A2 2 0 0 1 15.81 22H8.18a2 2 0 0 1-1.99-1.96z" />
                    </svg>
                    <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-stone-50 px-1 text-[0.65rem] font-semibold text-stone-900">
                        <?php echo esc_html(WC()->cart ? WC()->cart->get_cart_contents_count() : 0); ?>
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
