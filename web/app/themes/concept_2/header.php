<?php
if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-[#003745]'); ?>>
<?php wp_body_open(); ?>
<header class="border-b-4 border-[#003745] bg-[#F9E2B0]">
    <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between gap-6">
        <a class="text-2xl font-black tracking-tight" href="<?php echo esc_url(home_url('/')); ?>">
            POP BAG
        </a>
        <?php if (has_nav_menu('primary')) : ?>
            <nav class="hidden md:flex items-center gap-6 text-sm uppercase tracking-[0.08em] font-black">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>
        <?php endif; ?>
        <div class="flex items-center gap-3">
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="px-3 py-2 border-2 border-[#003745] rounded-full text-xs uppercase font-black hover:-translate-y-[2px] hover:-translate-x-[2px] transition-transform duration-150">Cart</a>
        </div>
    </div>
</header>
<main class="min-h-screen">

