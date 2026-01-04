<?php
/**
 * Footer template
 */
?>
    </main>
    <footer class="border-t-4 border-[#003745] bg-[#F4BB47] text-[#003745]">
        <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-8 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-lg font-black">POP BAG</p>
                <p class="text-sm font-semibold uppercase">FILL YOUR STYLE</p>
            </div>
            <?php
            if (has_nav_menu('footer')) {
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'flex flex-wrap gap-3 text-sm font-semibold uppercase',
                ]);
            }
            ?>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>

