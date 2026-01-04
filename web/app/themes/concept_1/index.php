<?php
/**
 * Fallback index template.
 */

get_header();
?>
<div class="mx-auto max-w-4xl px-4 py-12">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article <?php post_class('space-y-4'); ?>>
                <header class="border-b-4 border-[#003745] pb-3">
                    <h1 class="text-3xl font-black text-[#003745]"><?php the_title(); ?></h1>
                </header>
                <div class="prose max-w-none text-[#003745] prose-headings:font-black">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    else :
        ?>
        <p class="text-sm font-semibold text-[#003745]"><?php esc_html_e('Nothing found.', 'popbag'); ?></p>
    <?php endif; ?>
</div>
<?php
get_footer();

