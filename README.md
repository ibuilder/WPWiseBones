# WPWiseBones

> A comprehensive, production-ready **Bootstrap 5** WordPress starter theme with a companion shortcodes plugin.  
> Built and maintained by **[WPRealWise](https://wprealwise.com)** — Real Estate Tools for the Invested Realtor.

---

## Repository Contents

```
wpbones/
├── wpwisebones/               # WordPress theme
├── wpwisebones-shortcodes/    # Companion plugin (17 Bootstrap shortcodes)
├── wpwisebones.zip            # Distributable theme zip (built via npm run zip)
├── wpwisebones-shortcodes.zip # Distributable plugin zip
├── LICENSE                    # GNU GPL v2
└── README.md                  # This file
```

---

## Theme — WPWiseBones

**Version:** 1.0.2  
**Folder / Text Domain / Slug:** `wpwisebones`  
**PHP Prefix:** `wpb_` (functions) · `WPB_` (constants) · `wpb-` (CSS/HTML)  
**License:** GPL-2.0-or-later  
**Requires:** WordPress 6.0+, PHP 8.0+

### Features

- **Bootstrap 5.3** — CDN by default; switch to local vendor with one constant
- **Bootstrap Icons 1.11** — full icon set included
- **Full template hierarchy** — 22 templates (single, page, archive, category, tag, author, date, taxonomy, attachment, home, singular, 404, search, and more)
- **Customizer** — 6 panels, 18 settings, live `postMessage` preview for colours, hero & font size
- **Admin Options page** — Appearance → Theme Options (19 general + 5 performance toggles)
- **Per-post meta boxes** — layout override, hero image, hide title
- **3 custom widgets** — Recent Posts (with thumbnails), Social Links, CTA Banner
- **7 widget areas** — Primary Sidebar, 4× Footer columns, Header, Before/After Content, Shop Sidebar
- **Block editor** — `theme.json` colour palette, font sizes, layout widths; 7 block styles, 3 block patterns
- **SEO** — Open Graph, Twitter Card, Schema.org JSON-LD, canonical URL (auto-disabled when Yoast/RankMath/AIOSEO active)
- **WooCommerce** — Bootstrap wrapper, shop sidebar, styled notices
- **AJAX** — load-more posts handler, live search handler
- **Dashboard widget** — Getting Started panel with companion plugin status
- **Admin bar menu** — WPWiseBones → Theme Options / Customizer / Shortcodes
- **Translation-ready** — `.pot` included (`languages/wpwisebones.pot`)

### Customizer Sections

| Section | Transport | Notes |
|---------|-----------|-------|
| Header | refresh | Sticky toggle, light/dark scheme, top bar |
| Layout | refresh | Sidebar position, container width |
| Hero / Banner | postMessage | Heading, sub-heading, CTA button text/URL |
| Footer | refresh | Copyright text, widget columns, back-to-top |
| Brand Colours | postMessage | Primary, secondary, accent, header bg, footer bg |
| Typography | refresh / postMessage | Google Fonts body/heading, base font size |
| Social Links | refresh | Facebook, Twitter/X, Instagram, LinkedIn, YouTube, GitHub, Pinterest, TikTok |

### Key Constants (`wp-config.php`)

```php
// Serve Bootstrap from assets/vendor/ instead of CDN (for strict CSP)
define( 'WPB_LOCAL_ASSETS', true );
```

---

## Companion Plugin — WPWiseBones Shortcodes

**Version:** 1.0.0  
**Slug / Text Domain:** `wpwisebones-shortcodes`  
**Required by:** WordPress 6.0+, PHP 8.0+

> Shortcodes are plugin-territory per WordPress.org guidelines, so they live here rather than in the theme. The theme detects whether this plugin is active and shows a one-click install prompt when it is not.

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

## Development

### Prerequisites

- Node.js 18+ / npm 9+
- PHP 8.0+ (for syntax checks and WP-CLI)
- WP-CLI (for `.pot` generation) — `C:\Server\wp-cli.phar`

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
| `npm run preflight` | Full production readiness check (20 assertions) |

### Release Checklist

When making a new release, bump the version in **all four** of these places:

- `wpwisebones/style.css` → `Version:`
- `wpwisebones/functions.php` → `define( 'WPB_VERSION', ... )`
- `wpwisebones/package.json` → `"version"`
- `wpwisebones/readme.txt` → `Version:` + new changelog entry

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

### Theme (wpwisebones)

#### 1.0.2
- Fixed: Removed `remove_action('rest_api_init','wp_oembed_register_route')` — plugin territory per WP.org Theme Check

#### 1.0.1
- Fixed: Admin bar overlapping sticky header — header now correctly positioned below 32px (desktop) / 46px (mobile) admin bar
- Fixed: Body padding-top adjusted when admin bar + sticky header are both active
- Fixed: Customizer CSS output with null-safe hex color fallbacks
- Added: Selective refresh partials for site title, tagline, logo, hero, footer copyright
- Added: Google Fonts properly enqueued via `wp_enqueue_style`
- Improved: Customizer live preview JS for colours, hero, and font size

#### 1.0.0
- Initial production release
- Full Bootstrap 5.3 integration (CDN + local vendor fallback)
- 22 template files (full WP hierarchy)
- 18 Customizer settings across 6 sections
- Admin Options: 19 general + 5 performance toggles
- Per-post meta boxes: layout, hero, title visibility
- Open Graph, Twitter Card, Schema.org JSON-LD
- WooCommerce compatibility layer
- AJAX load-more and live search
- `theme.json` for block editor
- Translation-ready (`.pot` included)

### Plugin (wisebones-shortcodes)

#### 1.0.2
- Fixed: Renamed shortcode callbacks wpb_sc_* → wpbs_sc_* (correct plugin prefix)
- Fixed: Renamed shared globals to wpbs_ prefix (accordion, tabs)
- Fixed: Loop variable and esc_url() inlined for Plugin Check compliance

#### 1.0.1
- Fixed: Admin notice now correctly renders theme install link as HTML
- Fixed: Cleaned up duplicate theme-detection notice registration

#### 1.0.0
- Initial release — 17 Bootstrap 5 shortcodes
- Admin shortcode reference page (Plugins → WiseBones Shortcodes)
- Theme detection notice with one-click install link

---

## License

GNU General Public License v2 or later.  
See [LICENSE](LICENSE) for the full text.

Theme and plugin copyright © 2025 [WPWiseBones / WPRealWise](https://wprealwise.com).  
Bootstrap © The Bootstrap Authors — [MIT License](https://github.com/twbs/bootstrap/blob/main/LICENSE).  
Bootstrap Icons © The Bootstrap Authors — [MIT License](https://github.com/twbs/icons/blob/main/LICENSE).

---

## Building a child theme: the chrome you must port

Read this before starting a new child. It has caught every child theme in this
repository.

**`wpwisebones/style.css` does not load under a child theme.** The parent
enqueues `get_stylesheet_uri()`, which resolves to the *child's* `style.css`
once a child is active, so the parent's own 12 KB of chrome never arrives. The
parent's `assets/css/main.css` *does* still load, and covers core block,
gallery, alignment, form and `screen-reader-text` styles — so the gap is
narrower than it looks, but it is real.

**56 selectors exist only in that file.** Three of them matter enough to break
a site, and each was measured as broken in a real WordPress 7.1.4 install by
reading computed styles, not by diffing source:

| What | Computed under a child | Consequence |
|---|---|---|
| `#primaryNavbar.show` | `background: rgba(0,0,0,0)`, `padding: 0` | the opened mobile menu is **invisible**, rendered over the page — the toggle looks dead |
| `body.sticky-header .site-header` | `position: relative` | the sticky header option silently does nothing, and it **defaults to on** |
| `#back-to-top` | `position: static` | the button sits in the footer instead of floating |

As found, before the fix:

| Theme | Mobile menu | Sticky header | Back to top |
|---|---|---|---|
| RealWise | broken | broken | broken |
| AEC Forge | broken | broken | OK — its own `.af-b2t` |
| Becoming | broken | OK — `position: sticky` | OK |
| iBuilder | broken | broken | broken |

All four are fixed. Each fix lives in that theme's own
`assets/css/<slug>.css`, under a block headed **CHROME THE PARENT'S style.css
WOULD HAVE PROVIDED**, written in that theme's own palette tokens.

### If you start a new child

Copy that block from any of them and re-tint it. Two notes on the way it is
written:

* The header fix uses **`position: sticky`**, not the parent's
  `position: fixed`. Fixed takes the header out of flow and needs a body
  `padding-top` equal to the header's height — and that height comes from
  `--wpb-header-height`, which is itself defined only in the stylesheet that
  does not load. Sticky stays in flow, needs no padding, and cannot mismatch.
  Becoming already did it this way; the others now match.
* Only port what the theme actually lacks. AEC Forge's back-to-top was already
  complete and was left alone.

The other 53 selectors cover the companion plugin's `wpb-*` shortcodes, blog
comments, breadcrumbs and the landing template. Port those too **if the child
uses them** — not on principle.

### Why not just enqueue the parent's stylesheet

Because it also carries the base colours and typography a child exists to
replace. Loading it back would mean overriding it twice.
