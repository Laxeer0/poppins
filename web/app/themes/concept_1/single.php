<?php
/**
 * Single post template
 */

get_header();
?>
<div class="mx-auto max-w-3xl px-4 py-12">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article <?php post_class('space-y-6'); ?>>
                <header class="border-b-4 border-[#003745] pb-4">
                    <p class="text-xs font-bold uppercase text-[#FF2030]"><?php echo esc_html(get_the_date()); ?></p>
                    <h1 class="mt-2 text-4xl font-black text-[#003745]"><?php the_title(); ?></h1>
                </header>
                <div class="prose max-w-none text-[#003745] prose-headings:font-black prose-a:font-bold prose-a:text-[#FF2030] hover:prose-a:text-[#770417]">
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

