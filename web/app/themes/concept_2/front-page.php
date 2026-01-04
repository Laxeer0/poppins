<?php
/**
 * Front page template: Editorial Lookbook.
 */
get_header();

$stories = popbag_mock_stories();

$editors_picks = popbag_get_products_cached(
    'editors_picks',
    1800,
    [
        'limit'    => 8,
        'status'   => 'publish',
        'tag'      => ['editor-pick', 'editors-pick'],
        'orderby'  => 'date',
        'order'    => 'DESC',
    ]
);

$new_arrivals = popbag_get_products_cached(
    'new_arrivals',
    1800,
    [
        'limit'    => 8,
        'status'   => 'publish',
        'orderby'  => 'date',
        'order'    => 'DESC',
    ]
);

$best_sellers = popbag_get_products_cached(
    'best_sellers',
    3600,
    [
        'limit'     => 8,
        'status'    => 'publish',
        'meta_key'  => 'total_sales',
        'orderby'   => 'meta_value_num',
        'order'     => 'DESC',
    ]
);
?>

<section class="bg-white border-b-4 border-[#003745]">
    <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-2 gap-10 items-end">
        <div class="space-y-6">
            <div class="text-[54px] sm:text-[72px] leading-none font-black text-[#003745]">FILL YOUR STYLE</div>
            <p class="text-lg text-[#1F525E] max-w-xl">Editorial lookbook meets POP capsules. Discover sharp silhouettes, bold color blocks, and playful proportions.</p>
            <div class="flex flex-wrap gap-4">
                <a href="/shop" class="px-5 py-3 bg-[#FF2030] text-white rounded-full uppercase tracking-[0.08em] font-black hover:-translate-y-[2px] hover:-translate-x-[2px] transition-transform">Shop Now</a>
                <a href="/lookbook" class="px-5 py-3 border-3 border-[#003745] text-[#003745] rounded-full uppercase tracking-[0.08em] font-black hover:bg-[#F9E2B0]">Lookbook</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <?php
            $cover_tiles = [
                ['title' => 'Lookbook', 'link' => '/lookbook', 'color' => '#F9E2B0', 'label' => '01'],
                ['title' => 'Shop', 'link' => '/shop', 'color' => '#FF2030', 'label' => '02'],
                ['title' => 'Choose your size', 'link' => '#choose-size', 'color' => '#003745', 'label' => '03'],
            ];
            foreach ($cover_tiles as $tile) :
            ?>
            <a href="<?php echo esc_url($tile['link']); ?>" class="group relative aspect-[4/5] rounded-[24px] border-4 border-[#003745] overflow-hidden bg-white shadow-[10px_10px_0_0_rgba(0,55,69,0.35)] transition-transform hover:-translate-y-1 hover:-translate-x-1">
                <div class="absolute top-3 left-3 px-3 py-1 bg-white border-2 border-[#003745] rounded-full text-xs font-black uppercase tracking-[0.08em]"><?php echo esc_html($tile['label']); ?></div>
                <div class="w-full h-full" style="background-color: <?php echo esc_attr($tile['color']); ?>;"></div>
                <div class="absolute inset-0 flex items-end p-4">
                    <div class="text-2xl font-black text-white mix-blend-difference leading-none"><?php echo esc_html($tile['title']); ?></div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-[#F9E2B0] border-b-4 border-[#003745] py-12">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <span class="text-3xl font-black">LOOKBOOK / STORIES</span>
            <span class="text-sm uppercase tracking-[0.08em] font-black bg-white px-3 py-1 rounded-full border-2 border-[#003745]">Read</span>
        </div>
        <div class="text-sm font-semibold text-[#1F525E]">Swipe horizontally</div>
    </div>
    <div class="overflow-x-auto">
        <div class="min-w-[1200px] grid grid-cols-3 gap-6 px-6">
            <?php foreach ($stories as $story) : ?>
                <article class="relative border-4 border-[#003745] rounded-[20px] bg-white shadow-[10px_10px_0_0_rgba(0,55,69,0.35)] transition-transform hover:-translate-y-1 hover:-translate-x-1">
                    <div class="absolute top-3 left-3 px-3 py-1 bg-[#FF2030] text-white rounded-full text-xs font-black"><?php echo esc_html($story['label']); ?></div>
                    <div class="aspect-[3/4] overflow-hidden rounded-t-[16px] bg-[#1F525E]">
                        <img src="<?php echo esc_url($story['image'] ?: popbag_placeholder_img()); ?>" alt="<?php echo esc_attr($story['title']); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-xl font-black text-[#003745]"><?php echo esc_html($story['title']); ?></h3>
                        <p class="text-sm text-[#1F525E]"><?php echo esc_html($story['excerpt']); ?></p>
                        <a href="<?php echo esc_url($story['link']); ?>" class="inline-flex items-center gap-2 text-xs uppercase tracking-[0.08em] font-black">
                            Read <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-white border-b-4 border-[#003745] py-12">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <span class="text-3xl font-black text-[#003745]">EDITOR’S PICK</span>
            <span class="text-sm uppercase tracking-[0.08em] font-black bg-[#FF2030] text-white px-3 py-1 rounded-full">Capsule</span>
        </div>
        <a href="/shop" class="text-sm uppercase font-black underline">Shop all</a>
    </div>
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php
        if (!empty($editors_picks)) :
            foreach ($editors_picks as $product) :
                echo '<div>';
                popbag_render_product_card($product, __('Editor’s Pick', 'popbag-editorial'));
                echo '</div>';
            endforeach;
        else :
            echo '<p class="text-sm text-[#1F525E]">No picks yet.</p>';
        endif;
        ?>
    </div>
</section>

<section id="choose-size" class="bg-[#F9E2B0] border-b-4 border-[#003745] py-12">
    <div class="max-w-6xl mx-auto px-6 space-y-6">
        <div class="flex items-center gap-3">
            <span class="text-3xl font-black text-[#003745]">CHOOSE YOUR SIZE</span>
            <span class="text-sm uppercase font-black bg-white border-2 border-[#003745] px-3 py-1 rounded-full">Guide</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php
            $sizes = [
                ['label' => 'S', 'desc' => 'Compact fits and micro bags.', 'link' => '/shop/?filter_size=s', 'color' => '#F4BB47'],
                ['label' => 'M', 'desc' => 'Everyday carry with structure.', 'link' => '/shop/?filter_size=m', 'color' => '#003745'],
                ['label' => 'L', 'desc' => 'Oversized statements.', 'link' => '/shop/?filter_size=l', 'color' => '#FF2030'],
            ];
            foreach ($sizes as $size) :
            ?>
            <a href="<?php echo esc_url($size['link']); ?>" class="group relative flex flex-col gap-3 p-6 border-4 border-[#003745] rounded-[20px] bg-white shadow-[10px_10px_0_0_rgba(0,55,69,0.35)] transition-transform hover:-translate-y-1 hover:-translate-x-1">
                <div class="text-5xl font-black" style="color: <?php echo esc_attr($size['color']); ?>;"><?php echo esc_html($size['label']); ?></div>
                <div class="text-sm text-[#1F525E]"><?php echo esc_html($size['desc']); ?></div>
                <span class="inline-flex items-center gap-2 text-xs uppercase font-black">Shop <?php echo esc_html($size['label']); ?> <span aria-hidden="true">→</span></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="bg-white border-b-4 border-[#003745] py-12">
    <div class="max-w-6xl mx-auto px-6 space-y-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-3xl font-black text-[#003745]">NEW ARRIVALS</span>
                <span class="text-sm uppercase tracking-[0.08em] font-black bg-[#1F525E] text-white px-3 py-1 rounded-full">Fresh</span>
            </div>
            <a href="/shop" class="text-sm uppercase font-black underline">View all</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            if (!empty($new_arrivals)) :
                foreach ($new_arrivals as $product) :
                    echo '<div>';
                    popbag_render_product_card($product);
                    echo '</div>';
                endforeach;
            else :
                echo '<p class="text-sm text-[#1F525E]">No new arrivals.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<section class="bg-[#F9E2B0] py-12">
    <div class="max-w-6xl mx-auto px-6 space-y-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-3xl font-black text-[#003745]">BEST SELLERS</span>
                <span class="text-sm uppercase tracking-[0.08em] font-black bg-[#FF2030] text-white px-3 py-1 rounded-full">Top</span>
            </div>
            <a href="/shop" class="text-sm uppercase font-black underline">Shop all</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            if (!empty($best_sellers)) :
                foreach ($best_sellers as $product) :
                    echo '<div>';
                    popbag_render_product_card($product);
                    echo '</div>';
                endforeach;
            else :
                echo '<p class="text-sm text-[#1F525E]">No best sellers yet.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php
get_footer();

