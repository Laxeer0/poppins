<?php
/**
 * Footer template.
 *
 * @package Poppins
 */

?>
<footer class="site-footer">
    <div class="container site-footer__inner">
        <p>&copy; <?php echo esc_html(date_i18n('Y')); ?> Poppins. <?php esc_html_e('Tutti i diritti riservati.', 'poppins'); ?></p>

        <nav aria-label="<?php esc_attr_e('Menu footer', 'poppins'); ?>">
            <?php
            if (has_nav_menu('footer')) {
                wp_nav_menu(
                    [
                        'theme_location' => 'footer',
                        'container'      => false,
                        'fallback_cb'    => '__return_empty_string',
                    ],
                );
            }
?>
        </nav>

        <p><?php esc_html_e('Concepito a Milano con stoffe responsabili.', 'poppins'); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
