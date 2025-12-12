<?php
/**
 * Template principale della home.
 *
 * @package Poppins
 */

get_header();
?>

<main class="site-main">
    <section class="hero">
        <div class="container">
            <p class="hero-eyebrow"><?php esc_html_e('Nuova Capsule FW25', 'poppins'); ?></p>
            <h1><?php esc_html_e('Eleganza essenziale per ogni momento della giornata.', 'poppins'); ?></h1>
            <p><?php esc_html_e('Poppins seleziona tessuti responsabili e linee essenziali per creare capi senza stagione. Scopri la collezione pensata per chi vive la città e ama i dettagli.', 'poppins'); ?></p>
            <div class="hero-ctas">
                <a class="btn btn-primary" href="<?php echo esc_url(poppins_get_shop_url()); ?>">
                    <?php esc_html_e('Acquista ora', 'poppins'); ?>
                </a>
                <a class="btn btn-outline" href="#lookbook">
                    <?php esc_html_e('Guarda il lookbook', 'poppins'); ?>
                </a>
            </div>
        </div>
    </section>

    <section class="collections">
        <div class="container">
            <p class="section-heading"><?php esc_html_e('Categorie', 'poppins'); ?></p>
            <h2 class="section-title"><?php esc_html_e('Linee iconiche', 'poppins'); ?></h2>
            <?php if (poppins_has_woocommerce()) : ?>
                <?php echo do_shortcode('[product_categories number="3" columns="3" hide_empty="0"]'); ?>
            <?php else : ?>
                <p><?php esc_html_e('Attiva WooCommerce per mostrare automaticamente le categorie di prodotto.', 'poppins'); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="best-sellers">
        <div class="container">
            <p class="section-heading"><?php esc_html_e('Selezione curata', 'poppins'); ?></p>
            <h2 class="section-title"><?php esc_html_e('Best seller della settimana', 'poppins'); ?></h2>
            <?php if (poppins_has_woocommerce()) : ?>
                <?php echo do_shortcode('[products limit="4" columns="4" visibility="featured" orderby="popularity"]'); ?>
            <?php else : ?>
                <p><?php esc_html_e('Per vedere i prodotti aggiungi e attiva WooCommerce.', 'poppins'); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="story">
        <div class="container">
            <p class="section-heading"><?php esc_html_e('Manifesto', 'poppins'); ?></p>
            <div class="story-grid">
                <div>
                    <h2 class="section-title"><?php esc_html_e('Cura sartoriale, spirito contemporaneo.', 'poppins'); ?></h2>
                    <p><?php esc_html_e('I nostri capi nascono da filati naturali, prodotti in serie limitate e pensati per durare. Ogni dettaglio è progettato per accompagnare il ritmo metropolitano con grazia.', 'poppins'); ?></p>
                </div>
                <div>
                    <ul>
                        <li><?php esc_html_e('Tessuti certificati e filiera trasparente', 'poppins'); ?></li>
                        <li><?php esc_html_e('Vestibilità genderless e inclusiva', 'poppins'); ?></li>
                        <li><?php esc_html_e('Palette neutre e accenti bronzo', 'poppins'); ?></li>
                        <li><?php esc_html_e('Packaging riciclabile al 100%', 'poppins'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="lookbook" class="lookbook">
        <div class="container">
            <p class="section-heading"><?php esc_html_e('Lookbook', 'poppins'); ?></p>
            <h2 class="section-title"><?php esc_html_e('Mood urbano', 'poppins'); ?></h2>
            <div class="lookbook-grid">
                <article class="lookbook-card">
                    <small>Linea</small>
                    <h3><?php esc_html_e('Soft tailoring', 'poppins'); ?></h3>
                    <p><?php esc_html_e('Blazer destrutturati e pantaloni morbidi nelle tonalità della terra.', 'poppins'); ?></p>
                </article>
                <article class="lookbook-card">
                    <small>Capsule</small>
                    <h3><?php esc_html_e('Night bloom', 'poppins'); ?></h3>
                    <p><?php esc_html_e('Satin e seta vegetale per serate luminose, senza eccessi.', 'poppins'); ?></p>
                </article>
                <article class="lookbook-card">
                    <small>Essentials</small>
                    <h3><?php esc_html_e('Daily knits', 'poppins'); ?></h3>
                    <p><?php esc_html_e('Maglieria leggera e colori cremosi da sovrapporre.', 'poppins'); ?></p>
                </article>
                <article class="lookbook-card">
                    <small>Preview</small>
                    <h3><?php esc_html_e('Resort 25', 'poppins'); ?></h3>
                    <p><?php esc_html_e('Fluidità e tagli asimmetrici per il prossimo capitolo.', 'poppins'); ?></p>
                </article>
            </div>
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <p class="section-heading"><?php esc_html_e('Journal', 'poppins'); ?></p>
            <h2 class="section-title"><?php esc_html_e('Ricevi anteprime e inviti.', 'poppins'); ?></h2>
            <p><?php esc_html_e('Una email al mese con editorials, promozioni riservate e backstage.', 'poppins'); ?></p>
            <?php poppins_render_newsletter_form(); ?>
        </div>
    </section>
</main>

<?php
get_footer();
