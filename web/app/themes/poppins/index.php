<?php
/**
 * Template di fallback.
 *
 * @package Poppins
 */

get_header();
?>

<main class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e('Non ci sono contenuti da mostrare.', 'poppins'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
