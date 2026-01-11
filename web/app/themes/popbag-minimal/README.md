# POP BAG Minimal (Bedrock)

Tema classico WordPress + WooCommerce con markup Tailwind (asset compilato).

## Asset / Tailwind build

Percorso: `web/app/themes/popbag-minimal/`

- **Sorgente CSS**: `src/css/app.css`
- **Output build**: `dist/app.css` (enqueued dal tema con versioning via `filemtime()`)

Comandi:

```bash
cd web/app/themes/popbag-minimal
npm install
npm run dev    # watch
npm run build  # minify in dist/app.css
```

## Home (sezioni editabili)

Strategia: **Gutenberg-first** (senza ACF).

- `front-page.php` renderizza `the_content()` se la pagina Home ha contenuto.
- Se la Home è vuota, mostra il fallback mockup in `template-parts/home-fallback.php`.
- È disponibile un pattern “Home starter (mockup)” (categoria **POP BAG**) e shortcodes utili.

Shortcode slider prodotti:

```text
[popbag_product_swiper title="Bags" subtitle="Shop the essentials" source="new" limit="12" cta_label="Vedi tutto" cta_url="/shop/"]
```

## WooCommerce

- Override essenziali in `woocommerce/` (shop/single/cart/checkout + notices + my-account basics).
- Gli stili WooCommerce “di default” sono disabilitati (`woocommerce_enqueue_styles` → empty) perché il layout usa classi Tailwind.

## Feature custom “BAG” (combo)

Implementazione esistente (mu-plugin):

- `web/app/mu-plugins/poppins-bags.php`
  - CPT: `poppins_bag` (archive: `/bags`)
  - Meta: `_poppins_bag_slug`, `_poppins_bag_capacity`, `_poppins_bag_category_limits`
  - Meta prodotto: `_poppins_bags_available` (quali bag possono contenere quel prodotto)

Integrazione tema:

- Template:
  - `archive-poppins_bag.php` (lista bag)
  - `single-poppins_bag.php` (bag builder: selezione prodotti + submit)
- Carrello/ordine:
  - Il form aggiunge **più prodotti** al carrello come gruppo tramite meta `popbag_bag` (label + group_id).
  - La label “Bag” viene mostrata sotto le righe del carrello/checkout e salvata anche come meta riga ordine.



