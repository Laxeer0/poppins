<?php
/**
 * Header template
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-[#F9E2B0] text-[#003745]'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 bg-[#F9E2B0] border-b-4 border-[#003745] shadow-[6px_6px_0_#003745]">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
            <div class="flex items-center gap-3">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="font-black tracking-tight text-2xl md:text-3xl text-[#FF2030]">
                    POP BAG
                </a>
                <span class="rounded-full bg-[#003745] px-3 py-1 text-xs font-black uppercase text-[#F9E2B0]">FILL YOUR STYLE</span>
            </div>
            <button class="inline-flex items-center rounded-full border-4 border-[#003745] bg-white px-4 py-2 text-xs font-black uppercase text-[#003745] md:hidden" type="button" data-popbag-nav-toggle>
                Menu
            </button>
            <div class="hidden w-full max-w-2xl md:block">
                <form role="search" method="get" class="relative w-full" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" class="w-full rounded-full border-4 border-[#003745] bg-white px-4 py-3 text-sm font-semibold text-[#003745] shadow-[6px_6px_0_#003745] focus:outline-none focus:ring-4 focus:ring-[#FF2030]" placeholder="<?php esc_attr_e('Search products…', 'popbag'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                    <input type="hidden" name="post_type" value="product">
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-[#FF2030] px-4 py-2 text-xs font-black uppercase text-white shadow-[4px_4px_0_#003745]" type="submit"><?php esc_html_e('Search', 'popbag'); ?></button>
                </form>
            </div>
            <div class="flex items-center gap-3">
                <?php if (function_exists('wc_get_page_id')) : ?>
                    <?php $cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="flex items-center rounded-full border-4 border-[#003745] bg-white px-4 py-2 text-sm font-black text-[#003745] shadow-[6px_6px_0_#003745] hover:-translate-y-0.5 hover:shadow-[8px_8px_0_#003745] transition">
                        <span><?php esc_html_e('Cart', 'popbag'); ?></span>
                        <span id="popbag-cart-count" class="ml-2 inline-flex h-7 min-w-[28px] items-center justify-center rounded-full bg-[#FF2030] px-2 text-xs font-black text-white"><?php echo esc_html($cart_count); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="mx-auto hidden max-w-6xl items-center gap-4 px-4 pb-4 md:flex">
            <?php
            $categories = function_exists('popbag_get_primary_categories') ? popbag_get_primary_categories() : [];
            if (!empty($categories)) :
                ?>
                <nav class="flex flex-wrap items-center gap-3 text-sm font-semibold uppercase">
                    <?php foreach ($categories as $cat) : ?>
                        <a class="rounded-full border-4 border-[#003745] bg-white px-3 py-1 shadow-[4px_4px_0_#003745] hover:-translate-y-0.5 hover:shadow-[6px_6px_0_#003745] transition"
                           href="<?php echo esc_url(get_term_link($cat)); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
        <div class="md:hidden hidden px-4 pb-4" data-popbag-nav-mobile>
            <?php
            if (!empty($categories)) :
                ?>
                <nav class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase">
                    <?php foreach ($categories as $cat) : ?>
                        <a class="rounded-full border-4 border-[#003745] bg-white px-3 py-1 shadow-[4px_4px_0_#003745]" href="<?php echo esc_url(get_term_link($cat)); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main id="content" class="flex-1">

