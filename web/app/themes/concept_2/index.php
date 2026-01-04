<?php
get_header();
?>
<section class="bg-white py-12">
    <div class="max-w-5xl mx-auto px-6">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article class="prose max-w-none mb-10">
                <h1 class="text-4xl font-black mb-4"><?php the_title(); ?></h1>
                <div class="text-base text-[#1F525E] leading-relaxed">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; else : ?>
            <p class="text-sm text-[#1F525E]">No content found.</p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();

