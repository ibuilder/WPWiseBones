# PHX After Dark (child theme)

Brand layer for the PHX After Dark membership site. It supplies the palette,
typography, logo and page chrome; the **PHX Events Membership** plugin supplies
the event catalogue, membership, and all of the event templates.

## Requirements

- WordPress 6.4+
- PHP 8.1+
- Parent theme: **WPWiseBones** — a classic, Bootstrap 5 starter theme
  (<https://github.com/ibuilder/WPWiseBones>, directory slug `wpwisebones`)
- The `phx-events-membership` plugin, active

## Install

1. Install and activate WPWiseBones. From the repository, the theme is the
   `wpwisebones/` directory (there is also a prebuilt `wpwisebones.zip` at the
   repository root). Its optional companion plugin, `wisebones-shortcodes`, is
   not required by anything here.
2. Copy this directory to `wp-content/themes/phx-after-dark-child/`.
3. Activate **PHX After Dark** under Appearance → Themes.
4. Activate the PHX Events Membership plugin.

## How this child sits on top of WPWiseBones

WPWiseBones is a *classic* theme (`header.php` / `footer.php`, Bootstrap 5,
Customizer), not a block theme, so this child does not ship block templates or
template parts. Four integration points do the work:

| Concern | How it is handled |
| --- | --- |
| Stylesheet order | On WPWiseBones 1.0.13+ the parent enqueues its own `style.css`, then `main.css`, then this theme's `style.css` as `wpwisebones-child-style`, and `functions.php` leaves that alone — the resulting order is `bootstrap → bootstrap-icons → wpwisebones/style.css → wpwisebones/assets/css/main.css → child style.css → phx-after-dark.css`, so the child's tokens now win over the parent's `main.css`. On parents older than 1.0.13, `wpwisebones-style` resolved to *this* theme's `style.css` and the parent's base rules never loaded; there `functions.php` still registers the parent sheet as `phx-after-dark-parent` and appends it to that handle's dependencies, pinning the cascade to parent → child. Either way the brand layer that must win lives in `phx-after-dark.css` at the end. |
| Dark mode | Bootstrap 5.3 has a native colour mode. Rather than override every component, `functions.php` filters `language_attributes` to add `data-bs-theme="dark"`, and `style.css` retints the handful of Bootstrap variables the brand cares about. |
| Navbar variant | `theme_mod_wpwisebones_header_style` defaults to `dark` — a filter, not a hard-coded value, so the Customizer still wins if the site owner picks something else. |
| Member bar | WPWiseBones exposes no action hooks inside `header.php`, so the slim status strip is rendered on `wp_body_open` (above the navbar) instead of by copying the parent template. |

### theme.json

WordPress replaces a preset array wholesale rather than merging entry by entry,
so this child's `settings.color.palette` has to carry the parent's slugs as well
as its own or any existing `has-primary-color` markup would stop resolving. The
Bootstrap semantic slugs are kept but retinted for a dark ground:

| Parent slug | Value here |
| --- | --- |
| `primary` | neon mint `#12F7C0` |
| `dark` | night `#0B0B12` |
| `light` | ink `#F2F2F5` |
| `success` / `danger` / `warning` / `info` | kept semantic, lifted for contrast on night |

`normal` and `display` font sizes are carried over from the parent for the same
reason.

## Using a different parent theme

The child depends on its parent only for base styles and the site header, so
retargeting is a small change:

1. In `style.css`, change `Template: wpwisebones` to the parent's directory slug.
2. In `functions.php`, the WPWiseBones-specific pieces are the four rows in the
   table above — the `wpwisebones-style` dependency fix, `data-bs-theme`,
   `theme_mod_wpwisebones_header_style`, and the `wpwisebones-main` dependency.
   Each is guarded (`wp_style_is()`, a `false ===` default) so it is inert
   against a parent that does not define them, but a non-Bootstrap parent will
   want the `data-bs-theme` filter removed.
3. Re-check `theme.json` — the brand presets are self-contained, but the
   compatibility slugs listed above exist only for WPWiseBones and a different
   parent may define others.

`functions.php` reads the parent handle and version from `get_template()`, so
nothing there is hard-coded to a path.

## What is where

| Path | Purpose |
| --- | --- |
| `style.css` | Theme header, the three brand custom properties, and the Bootstrap dark-mode variables |
| `theme.json` | Palette, typography scale, block and element styles |
| `functions.php` | Enqueueing, menus, member bar, login branding, brand tokens for the plugin's placeholder art |
| `assets/css/phx-after-dark.css` | Retints the plugin's CSS custom properties, styles the chrome the plugin does not own, and covers the few places the parent hard-codes a light value |
| `assets/images/` | Logo, mark and favicon |
| `patterns/` | Homepage hero and membership call-to-action patterns (classic themes auto-register `patterns/`, so these still appear in the inserter) |

## How the theme and plugin fit together

The plugin's stylesheet is written entirely against CSS custom properties
(`--phx-accent`, `--phx-surface`, `--phx-line`, …) and loads only on plugin
screens. `assets/css/phx-after-dark.css` declares the plugin stylesheet as a
dependency and redefines those properties, so the brand wins without a single
`!important`.

`functions.php` also filters `phx_events_setting` so the placeholder artwork the
plugin generates for events with no licensed image uses the brand palette. That
keeps a rebrand to one file.

## Overriding plugin templates

Copy any file from `phx-events-membership/templates/` into
`phx-after-dark-child/phx-events/` — same relative path — and the plugin loads
yours instead. For example:

```
phx-after-dark-child/phx-events/partials/event-card.php
phx-after-dark-child/phx-events/emails/digest.php
```

## Accessibility notes

- The palette is checked for contrast: `--phx-ink` on `--phx-night` is roughly
  16:1, `--phx-ink-soft` on `--phx-surface` roughly 8:1, and the neon accent is
  only used for text on dark surfaces (about 11:1), never as light-on-neon.
- Focus styles are a 3px ring rather than an outline removal.
- `prefers-reduced-motion` disables the card lift and any transition.
- A print stylesheet strips the night palette so a member can print a plan.

## Menus

WPWiseBones already registers `primary`, `footer`, `topbar` and `mobile`, and
its `header.php` renders `primary` — so this child adds only the two locations
the parent has no equivalent for: `phx-member` and `phx-legal`.

The `[phx_join_cta]` shortcode renders a member-aware button — "Join" for
visitors, "Your account" for members — and can be dropped into a menu item or
any block that accepts a shortcode. The member bar uses it automatically.
