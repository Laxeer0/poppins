<?php
/**
 * Archivio Bag.
 *
 * @package PoppinsTailwind
 */

get_header();
?>

<main class="mx-auto w-full max-w-6xl px-6 py-16">
    <header class="text-center">
        <p class="text-xs uppercase tracking-[0.5em] text-stone-500"><?php esc_html_e('Capsule personalizzate', 'poppins'); ?></p>
        <h1 class="mt-4 text-4xl font-semibold text-stone-900"><?php esc_html_e('Le Bag Poppins', 'poppins'); ?></h1>
        <p class="mx-auto mt-4 max-w-2xl text-lg text-stone-600">
            <?php esc_html_e('Curiamo selezioni di capi coordinati con quantità definite per categoria. Scegli la bag che preferisci e componi il tuo guardaroba responsabile.', 'poppins'); ?>
        </p>
    </header>

    <?php if (have_posts()) : ?>
        <div class="mt-12 grid gap-8 md:grid-cols-2">
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <?php
                $bag_id   = get_the_ID();
                $capacity = (int) get_post_meta($bag_id, '_poppins_bag_capacity', true);
                $slug     = get_post_meta($bag_id, '_poppins_bag_slug', true);
                ?>
                <article class="flex h-full flex-col justify-between rounded-[32px] border border-stone-200 bg-white p-8 shadow-lg shadow-stone-200 transition hover:-translate-y-1">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-stone-500"><?php echo esc_html($slug ?: 'bag'); ?></p>
                        <h2 class="mt-3 text-3xl font-semibold text-stone-900">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="mt-2 text-sm uppercase tracking-[0.3em] text-stone-500">
                            <?php
                            printf(
                                /* translators: %d numero capi */
                                esc_html__('Fino a %d capi', 'poppins'),
                                max(1, $capacity),
                            );
                ?>
                        </p>
                        <div class="mt-4 text-stone-600"><?php the_excerpt(); ?></div>
                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <a class="btn btn-primary" href="<?php the_permalink(); ?>">
                            <?php esc_html_e('Esplora la bag', 'poppins'); ?>
                        </a>
                        <span class="text-xs uppercase tracking-[0.3em] text-stone-500"><?php esc_html_e('Curata per te', 'poppins'); ?></span>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="mt-12 text-center">
            <?php the_posts_pagination(
                [
                    'mid_size'           => 1,
                    'prev_text'          => __('&larr; Precedente', 'poppins'),
                    'next_text'          => __('Successivo &rarr;', 'poppins'),
                    'screen_reader_text' => '',
                ],
            ); ?>
        </div>
    <?php else : ?>
        <p class="mt-12 text-center text-stone-600"><?php esc_html_e('Non ci sono bag disponibili al momento.', 'poppins'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
