<?php
/**
 * Default page template
 */

get_header();
?>
<div class="mx-auto max-w-4xl px-4 py-12">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article <?php post_class('prose max-w-none text-[#003745] prose-headings:font-black prose-h1:text-4xl prose-h2:text-3xl'); ?>>
                <header class="mb-6 border-b-4 border-[#003745] pb-4">
                    <h1 class="text-4xl font-black text-[#003745]"><?php the_title(); ?></h1>
                </header>
                <div class="space-y-6">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</div>
<?php
get_footer();

