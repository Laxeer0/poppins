<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
</main>
<footer class="border-t-4 border-[#003745] bg-white">
    <div class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <div class="text-xl font-black mb-2">POP BAG</div>
            <p class="text-sm text-[#1F525E]">Editorial lookbook meets ecommerce. Fill your style.</p>
        </div>
        <div class="text-sm">
            <div class="font-black uppercase tracking-[0.08em] mb-2">Navigation</div>
            <?php
            if (has_nav_menu('footer')) {
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'items_wrap'     => '<ul class="space-y-1">%3$s</ul>',
                    'fallback_cb'    => false,
                ]);
            }
            ?>
        </div>
        <div class="text-sm">
            <div class="font-black uppercase tracking-[0.08em] mb-2">Follow</div>
            <div class="flex gap-3">
                <a class="underline" href="#">Instagram</a>
                <a class="underline" href="#">TikTok</a>
                <a class="underline" href="#">Newsletter</a>
            </div>
        </div>
    </div>
    <div class="border-t-4 border-[#003745] bg-[#F9E2B0] text-center text-xs uppercase tracking-[0.08em] font-black py-3">
        EDITORIAL POP — <?php echo esc_html(date('Y')); ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

