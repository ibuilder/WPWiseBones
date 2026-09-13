# Documentation screenshot renderer

Renders the themes and the shortcode plugin to static HTML **using their own code**,
screenshots the result with headless Chromium, and regenerates the shortcode
reference in `docs/shortcodes.html`. Nothing here ships in the theme or plugin zips.

## Why a stub instead of a WordPress install

The screenshots have to show what the code actually produces, and a full WordPress
install is not available in CI. `wp-stub.php` implements just enough of the
WordPress API — escaping, i18n, hooks, the shortcode parser (ported from
`wp-includes/shortcodes.php`), the loop, options, theme mods and template loading —
to execute the real templates and shortcode callbacks and capture their output.

## Files

| File | Role |
|------|------|
| `wp-stub.php` | Minimal WordPress API |
| `sample-data.php` | Placeholder images, sample posts, theme bootstrapping |
| `render.php` | Entry point — renders theme front pages and the shortcode demos |
| `render-theme.php` | Boots one theme (parent or child) and renders its front page |
| `render-shortcodes.php` | Runs all 17 shortcodes; writes the demo page and `shortcodes.json` |
| `capture.mjs` | Playwright: screenshots each page and each shortcode element |
| `build-shortcodes-page.php` | Rewrites the generated block of `docs/shortcodes.html` from the manifest |
| `set-image-dims.php` | Stamps each screenshot's real dimensions onto its `<img>` tag |

## Running it

```bash
npm install playwright            # once, anywhere on PATH for node
php  tools/docs-screenshots/render.php build
node tools/docs-screenshots/capture.mjs build docs/assets/img
php  tools/docs-screenshots/build-shortcodes-page.php build docs
php  tools/docs-screenshots/set-image-dims.php docs
```

`build/` is a scratch directory; only `docs/` is committed. Set `CHROMIUM_PATH` if
Chromium is not at Playwright's default location:

```bash
CHROMIUM_PATH=/path/to/chromium node tools/docs-screenshots/capture.mjs build docs/assets/img
```

## Notes

- Screenshots are taken with `reducedMotion: 'reduce'`, so the child themes' own
  `prefers-reduced-motion` rules disable the scroll-reveal animation and off-screen
  sections are captured fully visible.
- Stylesheets come from the themes' own `wp_enqueue_style()` calls, child themes
  included — `is_child_theme()` is part of the stub, so the parent and child
  stylesheets load in the same order they do on a real site.
- Sample post content and images are obvious placeholders, and the testimonial demo
  is labelled as illustrative rather than a customer quote.
- `get_theme_mod()` in the stub runs the `theme_mod_{$name}` filter, as WordPress does.
  Antivig sets the parent's header style and brand colours that way, so without it the
  child themes render with the parent's defaults instead of their own.
