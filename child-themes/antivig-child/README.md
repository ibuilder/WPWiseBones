# Antivig child theme

Child of [WPWiseBones](https://github.com/ibuilder/WPWiseBones) — a classic
Bootstrap 5.3 theme with no hooks of its own. Everything here extends it through
core hooks, the parent's `theme_mod_wpwisebones_*` filters and CSS layering.

## Install order

1. WPWiseBones (parent) — **v1.0.13 or newer**, which orders the parent and
   child stylesheets itself. v1.0.10 is the floor (it carries the fix for the
   `wpwisebones_load_more` AJAX handler); on 1.0.10–1.0.12 this theme corrects
   the cascade itself.
2. `antivig-membership` and `antivig-engine`.
3. This theme.

## How it extends the parent

| Concern | Approach |
| --- | --- |
| Parent CSS | On 1.0.13+ the parent enqueues its own `style.css`, then `main.css`, then this theme's `style.css` as `wpwisebones-child-style` — the order this theme wants, so `functions.php` leaves it alone. On older parents `wpwisebones-style` resolves to *this* theme's `style.css` and the parent's base rules never load; there `functions.php` registers the parent sheet separately and appends it to that handle's dependencies, pinning the cascade to parent → child regardless of enqueue order. |
| Brand layer | `assets/css/antivig.css`, enqueued with the parent and plugin handles as dependencies, so no `!important` is needed. |
| Tokens | `style.css` holds **only** custom properties. On pre-1.0.13 parents `main.css` loaded after it, so anything else there would lose. |
| Palette | `theme.json` re-declares the parent's Bootstrap slugs (`primary`, `dark`, `light`…) alongside the brand ones, because WordPress replaces preset arrays wholesale rather than merging them. |
| Colour mode | A six-line inline script sets Bootstrap's `data-bs-theme` from the reader's OS preference before first paint. It stores nothing. |
| Header additions | `wp_body_open` — the parent's `header.php` has no hooks, and copying it wholesale would mean inheriting its future bugs. |

## Fonts

The design calls for **Saira Condensed** (display), **IBM Plex Sans** (body) and
**IBM Plex Mono** (data), all self-hosted — the parent's Customizer fetches
Google Fonts at render time, which this theme deliberately does not do.

The WOFF2 files are **not in the repository yet**. Until they are added to
`assets/fonts/` with matching `@font-face` rules, the stacks in `style.css` fall
back to system faces, which is safe but is not the design. Both families are
SIL Open Font License 1.1.

## Still to build

- `screenshot.png` (1200×900) — `bin/build-dist.sh` warns while it is missing.
- `front-page.php` and `footer.php` overrides.
- Template overrides for the plugins under `antivig/`.
- Patterns for pricing, the ledger summary and a sport hub.
