# WPWiseBones child theme library

Every theme in this folder is a child of [`wpwisebones`](../wpwisebones/). `library.json`
lists them all with their family, schema type and default lead form.

| Theme | Family | For |
|---|---|---|
| [`wisebones-residential`](wisebones-residential/) | Real estate | Residential agents and brokerages |
| [`wisebones-commercial`](wisebones-commercial/) | Real estate | Commercial brokerage and investment sales |
| [`wisebones-property-management`](wisebones-property-management/) | Real estate | Property managers (listings become **Rentals**) |
| [`wisebones-mortgage`](wisebones-mortgage/) | Real estate | Mortgage brokers and lenders (payment calculator hero) |
| [`wisebones-title-escrow`](wisebones-title-escrow/) | Real estate | Title, escrow and settlement companies |
| [`wisebones-home-builder`](wisebones-home-builder/) | Real estate | New-home builders (Homes + Communities) |
| [`wisebones-general-contractor`](wisebones-general-contractor/) | Construction | GCs and construction managers |
| [`wisebones-remodeling`](wisebones-remodeling/) | Construction | Remodelers and design-build firms |
| [`wisebones-trades`](wisebones-trades/) | Construction | Roofing, HVAC, plumbing and electrical (Customizer preset) |
| [`wisebones-landscaping`](wisebones-landscaping/) | Construction | Landscape design, hardscape and maintenance |
| [`wisebones-architecture`](wisebones-architecture/) | Design | Architecture and engineering studios |
| [`wisebones-interiors`](wisebones-interiors/) | Design | Interior designers and home stagers |
| [`realwise`](realwise/) | Brand | wprealwise.com marketing site + EDD store |
| [`aec-forge`](aec-forge/) | Brand | AEC Market marketplace skin |
| [`antivig-child`](antivig-child/) | Brand (vendored) | Sports-analysis membership |
| [`phx-after-dark-child`](phx-after-dark-child/) | Brand (vendored) | Member-only event guide |

The twelve `wisebones-*` themes are built on the **industry framework**. The four brand
themes predate it and keep their own front pages and builders.

## How an industry theme is put together

```
wisebones-example/
  style.css            theme header + brand tokens (CSS custom properties)
  theme.json           block-editor palette and fonts
  industry-config.php  copy, section order, content types, starter site
  front-page.php       three lines: wpwisebones_industry_front_page()
  screenshot.png       1200x900
  readme.txt
```

The three pieces:

| Piece | Where | Does |
|---|---|---|
| Framework | `wpwisebones/inc/industry.php`, `template-parts/industry/`, `assets/css/industry.css` | Reads the config, renders sections, adds the *Front Page Sections* Customizer panel, header call to action and footer columns |
| Theme | `child-themes/wisebones-*` | Config + tokens. No templates of its own unless it overrides a section |
| Plugin | [`wisebones-industry-kit/`](../wisebones-industry-kit/) | Content types, meta, lead forms, schema, `[wbik_*]` shortcodes, Appearance → Starter Site |

Content types live in the plugin, not the theme, so a site keeps its listings and
projects if it switches theme (and so the themes stay within WordPress.org's rules).
Without the plugin a theme still renders: the sections that need content hide
themselves, and the hero falls back to a link instead of a form.

**Samples are never public.** Sample listings, projects and testimonials in a config are
shown only to users who can `edit_theme_options` (and in the Customizer preview), each
marked *Sample*. The starter site can import them, but only as drafts.

## `industry-config.php` reference

The file returns an array. Everything is optional except `hero` and `order`.

| Key | Type | Notes |
|---|---|---|
| `id`, `family`, `label` | string | Body classes `wpb-industry--{family}` and `wpb-industry--{id}` |
| `schema` | string | schema.org type for the business: `RealEstateAgent`, `GeneralContractor`, `RoofingContractor`, `HVACBusiness`, `Plumber`, `Electrician`, `FinancialService`, `ProfessionalService`, `HomeAndConstructionBusiness`, `LocalBusiness` |
| `content_types` | string[] | Any of `listing`, `project`, `service`, `team`, `testimonial` |
| `labels` | array | Relabel a type: `'listing' => array( 'Rentals', 'Rental' )`. Also sets the archive URL (`/rentals/`) |
| `lead_type` | string | Default form: `contact`, `quote`, `showing`, `valuation`, `prequal`, `owner`, `order` |
| `colors` | array | `primary`, `secondary`, `accent`, `header_bg`, `footer_bg` — defaults for Customizer → Brand Colours |
| `header_style` | `light`\|`dark` | Default navbar scheme |
| `header_cta` | `[ label, url, icon ]` | Button in the navbar |
| `hero` | array | `style` (`gradient`, `blueprint`, `glow`, `light`), `eyebrow`, `heading`, `text`, `primary`, `secondary`, `badges`, `panel` (`search`, `quote`, `calculator`, `card`, `none`) and that panel's data (`search`, `quote`, `calculator`, `card`) |
| `stats` | `[ [ figure, label ] ×4 ]` | Placeholders; the owner edits them in the Customizer |
| `sections` | array | Per-section `eyebrow`, `heading`, `text`, plus: `services.items` `[icon, title, text]`; `featured.type`/`samples`; `values.points`/`highlight`; `process.steps`; `testimonials.samples` `[quote, name, detail]`; `areas.items`; `faq.items` `[q, a]`; `cta.form` |
| `order` | string[] | Sections to render, in order |
| `footer` | array | `about`, `note` (licensing / disclosures), `columns` `{ heading: [ [label, url] ] }` |
| `starter` | array | `pages` `{ slug: { title, content } }`, `front`, `blog`, `menu` `[ [label, '/'\|'page:slug'\|'archive:type'\|url] ]`, `terms` `{ taxonomy: [names] }` |

URLs starting with `/` are resolved against the site's home URL.

The whole config passes through the `wpwisebones_industry_config` filter, so a site can
change copy or sections from a plugin without editing the theme.

## Adding a vertical

1. Copy the closest existing `wisebones-*` folder and rename it (folder, `Theme Name`,
   `Text Domain`, and the `@package` and closure-variable prefixes in the config).
2. Change the tokens at the top of `style.css` and the palette in `theme.json`.
3. Rewrite `industry-config.php`.
4. Regenerate the screenshot:
   `php tools/docs-screenshots/render.php build themes && node tools/docs-screenshots/capture.mjs build docs/assets/img`,
   then copy `docs/assets/img/lib-<slug>.png` to the theme's `screenshot.png`.
5. Add it to `library.json`.

CI picks up every folder here automatically: syntax check, activation on a real
WordPress install, and, for industry themes, a full front-page render with the kit active.

## Building zips

```
tools/build-library.sh                  # every theme + the Industry Kit -> dist/
tools/build-library.sh wisebones-trades # one theme
```
