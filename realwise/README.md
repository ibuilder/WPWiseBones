# RealWise — Portfolio & Storefront Theme

A child theme of **WPWiseBones** that rebrands the base into the RealWise identity
(navy `#1d3557` · emerald `#2a9d8f` · gold `#e9c46a`). It ships a self-contained
**marketing front page** that is live the moment you activate, plus an importer that
**auto-runs on first activation** to build the rest of the site and the EDD storefront.

## What you get on activation

The homepage renders immediately from `front-page.php`. The importer then builds:

- **Pages** (all on the *RealWise Marketing* full-bleed template): Home, Features,
  Pricing, Docs, About, Contact, plus a Blog posts page.
- **Static front page** (Home) and **posts page** (Blog) + one sample post.
- **Menus**: *RealWise Primary* (Home · Features · Pricing · Docs · Store · Blog ·
  About · Contact) and *RealWise Footer*, assigned to their theme locations.
- **Hero / brand** theme-mods (heading, subheading, CTA → Pricing).
- **Easy Digital Downloads storefront** (if EDD is active): two downloads —
  **RealWise** ($0) and **RealWise MLS** ($149/yr, placeholder). The real plugin
  zips bundled in this theme (`downloads/`) are copied into a protected uploads
  folder and attached. If **EDD Software Licensing** is active, the MLS download is
  marked license-enabled so it issues the keys the RealWise MLS plugin validates
  (its title stays exactly `RealWise MLS` to match the plugin's `item_name`).

Re-running is safe — pages and downloads are matched by a meta flag and updated in place, never duplicated.

## Install

1. Install & activate the **WPWiseBones** parent theme (`wpwisebones.zip`).
2. Install & activate this **RealWise** theme (`realwise-theme.zip`).
3. Recommended companions:
   - **WiseBones Shortcodes** (`wisebones-shortcodes.zip`) — required for the
     `[wpb_*]` page blocks to render.
   - **Easy Digital Downloads** (+ optionally **EDD Software Licensing**) — required for the storefront and license keys.
4. **That's it** — on activation the site auto-builds (pages, menus, hero, and EDD
   downloads if EDD is active) and the marketing homepage is live immediately.
   To rebuild later, use **Appearance → RealWise Demo → Import**.

> The homepage is rendered by `front-page.php` (Bootstrap, no shortcode-plugin
> dependency) so it looks right out of the box. Edit that template to change the
> homepage; the inner pages (Features, Pricing, …) are normal editable pages.

## After activation

- **Logo**: Appearance → Customize → Site Identity → upload
  `assets/images/realwise-logo.png` (transparent, ready to use). Vector versions
  (`realwise-logo.svg`, `realwise-mark.svg`) are included if you allow SVG uploads.
- **Prices**: Downloads → RealWise / RealWise MLS → edit the price (placeholders are
  $0 and $149/yr). The real plugin zips are already attached — the importer copies
  `downloads/realwise.zip` and `downloads/realwise-mls.zip` into a protected
  `uploads/edd/` folder.
- **Licensing**: with **EDD Software Licensing** active, RealWise MLS is already
  license-enabled (1 site, 1-year). Confirm the **Download** → License settings, and
  set your store's API to match the plugin's `PWM_STORE_URL` (`https://wprealwise.com`).
- **Downloads delivery**: EDD → Settings → Misc → File Download Method → **Forced**,
  so the protected zips are served only to buyers.
- **Hero & colours**: Appearance → Customize → WPWiseBones (hero) — brand colours
  come from `assets/css/realwise.css`.

## Files

```
realwise/
  style.css                     child theme header (Template: wpwisebones)
  functions.php                 enqueue brand CSS, editor palette, hero defaults, load importer
  assets/css/realwise.css       navy/emerald brand skin over Bootstrap 5
  assets/images/                realwise-logo.svg/.png + realwise-mark.svg
  page-templates/marketing.php  full-bleed page template (header + content + footer)
  inc/demo-content.php          the one-click EDD importer (pages, menus, downloads, mods)
  downloads/                    bundled realwise.zip + realwise-mls.zip (seeded into EDD)
  screenshot.png
```

Built for [WPRealWise.com](https://wprealwise.com).
