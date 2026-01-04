<?php
/**
 * Front page template
 */

get_header();

$shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/');
$best_ids = function_exists('popbag_get_best_seller_ids') ? popbag_get_best_seller_ids(12) : [];
$new_ids  = function_exists('popbag_get_new_arrival_ids') ? popbag_get_new_arrival_ids(12) : [];
$cats     = function_exists('popbag_get_primary_categories') ? popbag_get_primary_categories() : [];
?>

<section class="relative overflow-hidden border-b-4 border-[#003745] bg-[#F9E2B0]">
    <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 py-12 md:flex-row md:items-center md:justify-between">
        <div class="max-w-xl space-y-5">
            <p class="rounded-full bg-[#003745] px-4 py-2 text-xs font-black uppercase tracking-wide text-[#F9E2B0] shadow-[6px_6px_0_#770417]">POP / BRUTAL CLEAN</p>
            <h1 class="font-['5TH_AVE','5th Avenue','Arial Black',Arial,sans-serif] text-5xl font-black leading-[1.1] text-[#FF2030] md:text-6xl">
                FILL YOUR STYLE
            </h1>
            <p class="text-lg font-semibold text-[#003745]">Borse modulabili, colori audaci, vibes metropolitane. Scegli il tuo mix, cambia ogni giorno.</p>
            <div class="flex flex-wrap gap-3">
                <a class="inline-flex items-center gap-2 rounded-full bg-[#FF2030] px-6 py-3 text-sm font-black uppercase text-white shadow-[6px_6px_0_#003745] transition hover:-translate-y-0.5 hover:shadow-[8px_8px_0_#003745]" href="<?php echo esc_url($shop_url); ?>">
                    Shop now
                </a>
                <a class="inline-flex items-center gap-2 rounded-full border-4 border-[#003745] bg-white px-6 py-3 text-sm font-black uppercase text-[#003745] shadow-[6px_6px_0_#003745] transition hover:-translate-y-0.5 hover:shadow-[8px_8px_0_#003745]" href="#sizes">
                    Choose your size
                </a>
            </div>
        </div>
        <div class="relative w-full max-w-lg rounded-[24px] border-4 border-[#003745] bg-white p-6 shadow-[10px_10px_0_#003745]">
            <div class="absolute -left-4 -top-4 rounded-full bg-[#F4BB47] px-4 py-2 text-xs font-black uppercase text-[#003745] shadow-[4px_4px_0_#770417]">New drop</div>
            <div class="aspect-[4/5] w-full rounded-[16px] bg-gradient-to-br from-[#F9E2B0] via-white to-[#FF2030]"></div>
        </div>
    </div>
</section>

<section id="sizes" class="border-b-4 border-[#003745] bg-white">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="mb-8 flex items-center justify-between">
            <h2 class="text-3xl font-black text-[#003745] md:text-4xl">CHOOSE YOUR SIZE</h2>
            <span class="rounded-full bg-[#FF2030] px-3 py-1 text-xs font-black uppercase text-white shadow-[4px_4px_0_#003745]">Mix & Match</span>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <?php
            $sizes = [
                ['label' => 'S', 'desc' => 'Compatta, daily essentials', 'color' => '#F4BB47'],
                ['label' => 'M', 'desc' => 'Equilibrata, city ready', 'color' => '#1F525E'],
                ['label' => 'L', 'desc' => 'Statement, travel & week-end', 'color' => '#FF2030'],
            ];
            foreach ($sizes as $size) :
                ?>
                <div class="group relative overflow-hidden rounded-[20px] border-4 border-[#003745] bg-[#F9E2B0] p-6 shadow-[10px_10px_0_#003745] transition hover:-translate-y-1">
                    <div class="absolute -right-3 -top-3 rotate-3 rounded-full px-3 py-1 text-xs font-black uppercase text-white shadow-[4px_4px_0_#003745]" style="background: <?php echo esc_attr($size['color']); ?>">
                        POP BAG
                    </div>
                    <h3 class="text-4xl font-black text-[#003745]"><?php echo esc_html($size['label']); ?></h3>
                    <p class="mt-3 text-sm font-semibold text-[#003745]"><?php echo esc_html($size['desc']); ?></p>
                    <a href="<?php echo esc_url($shop_url); ?>" class="mt-6 inline-flex items-center rounded-full border-4 border-[#003745] bg-white px-4 py-2 text-xs font-black uppercase text-[#003745] shadow-[4px_4px_0_#003745] transition hover:-translate-y-0.5 hover:shadow-[6px_6px_0_#003745]">Explora</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="border-b-4 border-[#003745] bg-[#F9E2B0]">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-3xl font-black text-[#003745] md:text-4xl">Best sellers</h2>
            <span class="rounded-full bg-[#003745] px-3 py-1 text-xs font-black uppercase text-[#F9E2B0] shadow-[4px_4px_0_#770417]">Cached 1h</span>
        </div>
        <?php
        if (!empty($best_ids)) :
            $best_query = popbag_build_product_query($best_ids);
            if ($best_query->have_posts()) :
                ?>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <?php
                    while ($best_query->have_posts()) :
                        $best_query->the_post();
                        wc_get_template_part('content', 'product');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <p class="text-sm font-semibold text-[#003745]"><?php esc_html_e('No best sellers found yet.', 'popbag'); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="border-b-4 border-[#003745] bg-white">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-3xl font-black text-[#003745] md:text-4xl">New arrivals</h2>
            <span class="rounded-full bg-[#FF2030] px-3 py-1 text-xs font-black uppercase text-white shadow-[4px_4px_0_#003745]">Cached 30'</span>
        </div>
        <?php
        if (!empty($new_ids)) :
            $new_query = popbag_build_product_query($new_ids);
            if ($new_query->have_posts()) :
                ?>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <?php
                    while ($new_query->have_posts()) :
                        $new_query->the_post();
                        wc_get_template_part('content', 'product');
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <p class="text-sm font-semibold text-[#003745]"><?php esc_html_e('No new arrivals yet.', 'popbag'); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($cats)) : ?>
<section class="border-b-4 border-[#003745] bg-[#1F525E] text-[#F9E2B0]">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-3xl font-black md:text-4xl">Categorie</h2>
            <span class="rounded-full bg-[#F4BB47] px-3 py-1 text-xs font-black uppercase text-[#003745] shadow-[4px_4px_0_#770417]">Cached 12h</span>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($cats as $cat) : ?>
                <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="group flex flex-col justify-between rounded-[18px] border-4 border-[#F9E2B0] bg-[#003745] p-5 shadow-[8px_8px_0_#770417] transition hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-black uppercase"><?php echo esc_html($cat->name); ?></h3>
                        <span class="rounded-full bg-[#F9E2B0] px-3 py-1 text-xs font-black uppercase text-[#003745]"><?php echo esc_html($cat->count); ?> prod.</span>
                    </div>
                    <?php if ($cat->description) : ?>
                        <p class="mt-3 text-sm font-semibold text-[#F9E2B0]/80 line-clamp-2"><?php echo esc_html(wp_trim_words($cat->description, 15)); ?></p>
                    <?php endif; ?>
                    <span class="mt-4 inline-flex w-fit items-center gap-2 rounded-full bg-[#FF2030] px-4 py-2 text-xs font-black uppercase text-white shadow-[4px_4px_0_#003745] group-hover:translate-y-1 transition">Scopri</span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>

