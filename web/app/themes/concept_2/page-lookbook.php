<?php
/**
 * Template Name: Lookbook
 */
get_header();

$stories = popbag_mock_stories();
$shop_the_look = popbag_get_products_cached(
    'lookbook_shop',
    1800,
    [
        'limit'   => 6,
        'status'  => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
    ]
);
?>

<section class="bg-[#F9E2B0] border-b-4 border-[#003745]">
    <div class="max-w-6xl mx-auto px-6 py-10 space-y-3">
        <div class="text-sm uppercase tracking-[0.1em] font-black">POP BAG — Editorial</div>
        <h1 class="text-[56px] leading-none font-black text-[#003745]">Lookbook / Stories</h1>
        <p class="text-lg text-[#1F525E] max-w-2xl">Collage of capsules, backstage notes, and curated fits. Scroll like a magazine.</p>
    </div>
</section>

<section class="bg-white border-b-4 border-[#003745] py-12">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php foreach ($stories as $story) : ?>
            <article class="border-4 border-[#003745] rounded-[20px] overflow-hidden shadow-[10px_10px_0_0_rgba(0,55,69,0.35)]">
                <div class="aspect-[4/5] bg-[#1F525E]">
                    <img src="<?php echo esc_url($story['image'] ?: popbag_placeholder_img()); ?>" alt="<?php echo esc_attr($story['title']); ?>" class="w-full h-full object-cover">
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-[#FF2030] text-white text-xs font-black rounded-full"><?php echo esc_html($story['label']); ?></span>
                        <span class="text-xs uppercase tracking-[0.08em] font-black text-[#1F525E]">Story</span>
                    </div>
                    <h2 class="text-2xl font-black text-[#003745]"><?php echo esc_html($story['title']); ?></h2>
                    <p class="text-sm text-[#1F525E]"><?php echo esc_html($story['excerpt']); ?></p>
                    <a href="<?php echo esc_url($story['link']); ?>" class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.08em] font-black">Read →</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="bg-[#F9E2B0] py-12">
    <div class="max-w-6xl mx-auto px-6 space-y-6">
        <div class="flex items-center gap-3">
            <span class="text-3xl font-black text-[#003745]">Shop the look</span>
            <span class="text-sm uppercase tracking-[0.08em] font-black bg-white px-3 py-1 border-2 border-[#003745] rounded-full">Editors</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (!empty($shop_the_look)) :
                foreach ($shop_the_look as $product) :
                    echo '<div>';
                    popbag_render_product_card($product, __('Editor’s Pick', 'popbag-editorial'));
                    echo '</div>';
                endforeach;
            else :
                echo '<p class="text-sm text-[#1F525E]">No products yet.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php
get_footer();

