# WPWiseBones

> A comprehensive, production-ready **Bootstrap 5** WordPress starter theme with a companion shortcodes plugin.  
> Built and maintained by **[WPRealWise](https://wprealwise.com)** — Real Estate Tools for the Invested Realtor.

📖 **[Documentation site with screenshots →](https://ibuilder.github.io/wpwisebones/)**
(source in [`docs/`](docs/), screenshots rendered from the code by
[`tools/docs-screenshots/`](tools/docs-screenshots/))

---

## Repository Contents

```
wpwisebones/                # WordPress theme
wisebones-shortcodes/       # Companion plugin (17 Bootstrap shortcodes)
realwise/                   # Child theme - real-estate marketing site + EDD storefront
aec-forge/                  # Child theme - AEC/BIM marketplace skin
docs/                       # Documentation site (GitHub Pages)
tools/docs-screenshots/     # Renders the themes and shortcodes for the doc screenshots
wpwisebones.zip             # Distributable theme zip (built via npm run zip)
wisebones-shortcodes.zip    # Distributable plugin zip
aec-forge-theme.zip         # Distributable child theme zip
LICENSE                     # GNU GPL v2
README.md                   # This file
```

---

## Theme — WPWiseBones

**Version:** 1.0.13  
**Folder / Text Domain / Slug:** `wpwisebones`  
**PHP Prefix:** `wpwisebones_` (functions) · `WPWISEBONES_` (constants) · `wpb-` (CSS/HTML)  
**License:** GPL-2.0-or-later  
**Requires:** WordPress 6.0+, PHP 7.4+ · Tested up to WordPress 7.0

### Features

- **Bootstrap 5.3.3** — served from `assets/vendor/`, never a CDN (WP.org Guideline 8)
- **Bootstrap Icons 1.11.3** — full icon set bundled, webfont included
- **Full template hierarchy** — index, home, singular, single, page, archive, category, tag, author, date, taxonomy, attachment, search, 404, comments, plus 2 page templates (Full Width, Landing Page)
- **Customizer** — 1 panel, 7 sections, 25 settings; live `postMessage` preview for colours, hero & base font size
- **Admin Options page** — Appearance → Theme Options (14 general + 5 performance toggles)
- **Per-post meta boxes** — layout override, hero image, hero sub-text, hide title
- **3 custom widgets** — Recent Posts (with thumbnails), Social Links, CTA Banner
- **9 widget areas** — Primary Sidebar, 4× Footer columns, Header, Before/After Content, Shop Sidebar
- **4 menu locations** — primary, footer, topbar, mobile, rendered through a Bootstrap 5 nav walker
- **Block editor** — `theme.json` (9-colour palette, 6 font sizes, layout widths); 7 block styles, 3 block patterns
- **SEO** — Open Graph, Twitter Card, Schema.org JSON-LD (auto-disabled when Yoast/RankMath/AIOSEO active; canonical left to WP core)
- **WooCommerce** — Bootstrap wrapper, shop sidebar, styled notices
- **AJAX** — load-more posts handler, live search handler (both nonce-checked)
- **Dashboard widget** — Getting Started panel with companion plugin status
- **Translation-ready** — `.pot` included (`languages/wpwisebones.pot`, 277 strings)

### Customizer Sections

| Section | Transport | Notes |
|---------|-----------|-------|
| Header | refresh | Sticky toggle, light/dark scheme, top bar |
| Layout | refresh | Default layout (right/left sidebar, full width), container width |
| Hero / Banner | postMessage | Heading, sub-heading, CTA button text/URL |
| Footer | refresh | Copyright text, widget columns, back-to-top |
| Brand Colours | postMessage | Primary, secondary, accent, header bg, footer bg |
| Typography | refresh / postMessage | Google Fonts body/heading, base font size |
| Social Links | refresh | Facebook, Twitter/X, Instagram, LinkedIn, YouTube, GitHub, Pinterest, TikTok |

### Assets

Bootstrap and Bootstrap Icons are always served from `assets/vendor/` — there is no CDN
branch and no constant to switch, which is what WordPress.org Guideline 8 requires.
`npm run sync` re-copies them from `node_modules/` after a dependency bump.

---

## Companion Plugin — WiseBones Shortcodes

**Version:** 1.0.7  
**Folder / Slug / Text Domain:** `wisebones-shortcodes`  
**PHP Prefix:** `wpbs_`  
**Requires:** WordPress 6.0+, PHP 7.4+ · Tested up to WordPress 7.0

> Shortcodes are plugin-territory per WordPress.org guidelines, so they live here rather than in the theme. The theme detects whether this plugin is active and shows a one-click install prompt when it is not. Bootstrap 5 and Bootstrap Icons are bundled with the plugin too and load only when the active theme does not already provide them, so the shortcodes work with any theme.

### Shortcodes (17)

| Shortcode | Description |
|-----------|-------------|
| `[wpb_alert]` | Dismissible Bootstrap alert (success/danger/warning/info) |
| `[wpb_button]` | Button with variant, size, and Bootstrap Icon |
| `[wpb_card]` | Bootstrap card with image, title, body, button |
| `[wpb_accordion]` / `[wpb_accordion_item]` | Collapsible FAQ accordion |
| `[wpb_tabs]` / `[wpb_tab]` | Tabbed content (tabs, pills, underline) |
| `[wpb_row]` / `[wpb_col]` | Bootstrap 12-column responsive grid |
| `[wpb_cta]` | Call-to-action banner with gradient and dual buttons |
| `[wpb_icon_box]` | Icon + heading + text feature box (Bootstrap Icons) |
| `[wpb_progress]` | Animated progress bar with label |
| `[wpb_testimonial]` | Testimonial with star rating and avatar |
| `[wpb_countdown]` | Live JS countdown timer |
| `[wpb_posts]` | Post card grid from WP_Query |
| `[wpb_modal]` | Bootstrap modal popup |
| `[wpb_badge]` | Inline Bootstrap badge / label |
| `[wpb_divider]` | Styled HR with optional centred text |
| `[wpb_map]` | Responsive iframe map embed |
| `[wpb_contact_info]` | Contact info list with Bootstrap Icons |

---

## Child Themes

Two ready-made skins keep WPWiseBones as the parent — each adds a brand stylesheet, a
self-contained marketing front page and a one-click builder for the rest of the site.
Full details on the [documentation site](https://ibuilder.github.io/wpwisebones/child-themes.html).

| Theme | Version | What it is |
|-------|---------|------------|
| [`realwise/`](realwise/) | 1.3.4 | Navy/amber real-estate marketing site. Its importer (auto-run on activation, re-runnable from Appearance → RealWise Demo) builds the pages, menus, hero mods and an Easy Digital Downloads storefront. |
| [`aec-forge/`](aec-forge/) | 1.1.2 | Charcoal/orange marketplace skin for AEC, BIM and Excel tooling. Appearance → AEC Forge Setup builds the promo pages and menus; reads live data from the AEC Market plugin when it is active. |

---

## Development

### Prerequisites

- Node.js 18+ / npm 9+
- PHP 7.4+ (for syntax checks and the test runner)
- WP-CLI (for `.pot` generation) — the `pot` script points at `C:\Server\wp-cli.phar`;
  on macOS or Linux run `wp i18n make-pot . languages/wpwisebones.pot --domain=wpwisebones` directly

### Setup

```bash
cd wpwisebones
npm install          # installs Bootstrap 5, Bootstrap Icons, archiver
```

### npm Scripts

| Command | What it does |
|---------|-------------|
| `npm run sync` | Re-copy Bootstrap from `node_modules/` to `assets/vendor/` |
| `npm run pot` | Regenerate `.pot` translation file (requires WP-CLI + live WP install) |
| `npm run zip` | Build distributable `wpwisebones.zip` (node_modules excluded) |
| `npm run preflight` | Full production readiness check — must report 0 errors before a release |
| `npm test` | Integration tests against a real WordPress install (`WPWISEBONES_TEST_WP=/path/to/wp`) |

### Release Checklist

When making a new release, bump the version in **all four** of these places:

- `wpwisebones/style.css` → `Version:`
- `wpwisebones/functions.php` → `define( 'WPWISEBONES_VERSION', ... )`
- `wpwisebones/package.json` → `"version"`
- `wpwisebones/readme.txt` → `Stable tag:` + new changelog entry

Then run:

```bash
cd wpwisebones
npm run preflight    # must pass 0 errors
npm run zip          # builds wpwisebones.zip
```

---

## WordPress.org Compliance

All REQUIRED and RECOMMENDED checks from the [Theme Review Guidelines](https://make.wordpress.org/themes/handbook/review/required/) pass:

- ✅ Theme name contains no "WordPress" or "theme"
- ✅ Text domain matches folder slug (`wpwisebones`)
- ✅ No `add_shortcode()` in theme (moved to companion plugin)
- ✅ No plugin-territory `remove_action` calls
- ✅ Copyright notice in `style.css`
- ✅ All customizer `add_setting()` have `sanitize_callback`
- ✅ `wp_head()`, `wp_footer()`, `wp_body_open()` all present
- ✅ No inline `<script>` in template files
- ✅ `register_block_style` (7) + `register_block_pattern` (3)
- ✅ `.gallery-caption`, `.bypostauthor`, `.screen-reader-text` CSS
- ✅ No UTF-8 BOM in any file
- ✅ LF-only line endings in `readme.txt`
- ✅ Theme URI ≠ Author URI
- ✅ No deprecated tags in `style.css`

---

## Changelog

Full, per-release changelogs live with each package, where WordPress.org reads them:

- Theme — [`wpwisebones/readme.txt`](wpwisebones/readme.txt) (current: **1.0.13**)
- Plugin — [`wisebones-shortcodes/readme.txt`](wisebones-shortcodes/readme.txt) (current: **1.0.7**)

Most recent entries:

### Theme 1.0.13

- Fixed: the theme stylesheet was enqueued as `get_stylesheet_uri()`, which under a child
  theme resolves to the child's `style.css` — so on a child theme site none of the parent
  `style.css` loaded, and rules that live only there (including the `.skip-link`
  visually-hidden rule, which made "Skip to content" render as a visible link on every
  page) were missing. The parent stylesheet is now always enqueued, with the child's
  after it when a child theme is active.

### Plugin 1.0.7

- Fixed: BOM removed from `readme.txt`, dead `Plugin URI` header removed, `ABSPATH` guard
  added to the silence files, `uninstall.php` added, bundled library sources documented.

---

## License

GNU General Public License v2 or later.  
See [LICENSE](LICENSE) for the full text.

Theme and plugin copyright © 2025 [WPWiseBones / WPRealWise](https://wprealwise.com).  
Bootstrap © The Bootstrap Authors — [MIT License](https://github.com/twbs/bootstrap/blob/main/LICENSE).  
Bootstrap Icons © The Bootstrap Authors — [MIT License](https://github.com/twbs/icons/blob/main/LICENSE).
