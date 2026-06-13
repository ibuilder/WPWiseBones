WPWiseBones
================

Version:        1.0.4
Requires WP:    6.0+
Tested up to:      7.0
Requires PHP:   8.0+
License:        GPLv2 or later
Author:         WPWiseBones
Author URI:     https://wprealwise.com
Text Domain:    wpwisebones

== Description ==

WPWiseBones is a comprehensive, production-ready WordPress starter theme
built on Bootstrap 5.3. It ships with everything a professional developer or
agency needs out of the box — shortcodes, custom widgets, a full admin options
panel, the Customizer, Open Graph SEO, WooCommerce support, and more.

Built and maintained by WPWiseBones.com — https://wprealwise.com

== Features ==

Bootstrap 5 (local vendor by default; CDN opt-in via WPB_LOCAL_ASSETS constant)
Bootstrap Icons 1.11
theme.json for block editor color/font/layout sync
17 Shortcodes (see Shortcode Reference below)
3 Custom Widgets
7 Widget Areas (Sidebar, 4x Footer columns, Header, Before/After Content, Shop)
Customizer: colors, Google Fonts, layout, header, hero, footer, social links
Admin Options page (Appearance → Theme Options)
Per-post meta boxes: layout override, hero image, hide title
Full template hierarchy: single, page, archive, category, tag, author, date,
  taxonomy, attachment, search, 404, home, singular
Open Graph + Twitter Card + Schema.org JSON-LD (auto-disabled with Yoast/RankMath/AIOSEO)
WooCommerce compatible: Bootstrap wrappers, shop sidebar, Bootstrap notices
AJAX load-more + live search handlers
Preloader, back-to-top, breadcrumbs, reading time, social share, related posts
Author box, smooth scroll, custom CSS/JS injection
Performance: disable emojis, oEmbeds, XML-RPC; remove version strings; defer scripts
Translation-ready (.pot included)

== Shortcode Reference ==

[wpb_alert type="success" dismissible="true"]Message[/wpb_alert]
[wpb_button url="/page" style="primary" size="lg" icon="bi-envelope"]Label[/wpb_button]
[wpb_card title="Title" image="URL" btn_text="More" btn_url="#"]Body[/wpb_card]
[wpb_accordion][wpb_accordion_item title="FAQ"]Answer[/wpb_accordion_item][/wpb_accordion]
[wpb_tabs][wpb_tab title="Tab 1" active="true"]Content[/wpb_tab][/wpb_tabs]
[wpb_row gutter="4"][wpb_col size="6"]Left[/wpb_col][wpb_col size="6"]Right[/wpb_col][/wpb_row]
[wpb_cta heading="Ready?" btn_text="Start" btn_url="/contact"]Subtext[/wpb_cta]
[wpb_icon_box icon="bi-rocket" title="Fast"]Description[/wpb_icon_box]
[wpb_progress label="HTML" value="90" color="primary"]
[wpb_testimonial author="Jane Doe" role="CEO" stars="5"]Quote[/wpb_testimonial]
[wpb_countdown date="2025-12-31 23:59:59" label="Launching in"]
[wpb_posts count="3" columns="3" category="news" show_excerpt="true"]
[wpb_modal title="Title" btn_text="Open"]Modal body[/wpb_modal]
[wpb_badge color="danger" pill="true"]Hot[/wpb_badge]
[wpb_divider text="OR" style="dashed"]
[wpb_map src="https://maps.google.com/maps?q=...&output=embed" height="400"]
[wpb_contact_info phone="+1 555 0100" email="hello@example.com" address="123 Main St"]

== Installation ==

1. Upload the wpwisebones/ folder to /wp-content/themes/
2. Activate via Appearance → Themes
3. Go to Appearance → Theme Options to configure
4. Assign menus under Appearance → Menus (Primary, Footer, Top Bar)
5. Add widgets under Appearance → Widgets

== Local Bootstrap Assets (CSP / No-CDN) ==

Bootstrap is served from local vendor/ by default (WP.org compliance). To use
the jsDelivr CDN instead, add to wp-config.php:

  define( 'WPB_LOCAL_ASSETS', false );  // in wp-config.php

Local copies are in assets/vendor/ (synced via: npm run sync).

== Development Scripts ==

  npm install          Install dependencies
  npm run sync         Re-copy Bootstrap from node_modules to assets/vendor/
  npm run pot          Regenerate .pot translation file (requires WP-CLI)
  npm run zip          Build distributable .zip
  npm run preflight    Full production readiness check

== Changelog ==

= 1.0.1 —
* Fixed: admin bar overlapping sticky header — header now correctly positioned below 32px admin bar on desktop and 46px on mobile
* Fixed: body padding-top adjusted for admin bar + sticky header combination
* Improved: Customizer CSS output with null-safe hex color fallbacks
* Added: Selective refresh partials for site title, tagline, logo, hero, footer copyright
* Added: Google Fonts properly enqueued via wp_enqueue_style
* Improved: Customizer live preview JS for colours, hero, font size

= 1.0.0 — 2025-06-06 =
* Initial production release
* Full Bootstrap 5.3 integration (CDN + local vendor)
* 17 shortcodes, 3 custom widgets, 7 sidebar areas
* Full template hierarchy (22 template files)
* Customizer: 50+ settings across 6 sections
* Admin Options: 19 general + 5 performance toggles
* Per-post meta boxes: layout, hero, title visibility
* Open Graph, Twitter Card, Schema.org JSON-LD
* WooCommerce compatibility layer
* AJAX load-more and live search
* theme.json for block editor
* Translation-ready (.pot included, 175+ strings)
* WPWiseBones.com credits in admin


== Companion Plugin ==

This theme works with a FREE companion plugin that adds 17 Bootstrap 5 shortcodes.
Install: WPWiseBones Shortcodes
URL:     https://wprealwise.com/wpwisebones#shortcodes

The theme detects whether the plugin is active and:
- Shows a dismissible dashboard notice with a one-click install link when not installed
- Shows companion plugin status on the admin bar (Theme Options > WPWiseBones menu)
- Shows plugin status in the Getting Started dashboard widget
- Shows plugin status in Appearance > Theme Options

Once installed, you get 17 shortcodes:
[wpb_alert]  [wpb_button]  [wpb_card]  [wpb_accordion]  [wpb_tabs]
[wpb_row] / [wpb_col]  [wpb_cta]  [wpb_icon_box]  [wpb_progress]
[wpb_testimonial]  [wpb_countdown]  [wpb_posts]  [wpb_modal]
[wpb_badge]  [wpb_divider]  [wpb_map]  [wpb_contact_info]
== Changelog ==

= 1.0.2 =
* Fixed: Removed `remove_action( 'rest_api_init', 'wp_oembed_register_route' )` (plugin territory per WP.org Theme Check)

= 1.0.4 =
* Fixed: WPB_LOCAL_ASSETS now defaults to true — Bootstrap served locally by default (WP.org compliance, Required §9)
* Fixed: inc/demo-importer.php excluded from WP.org submission zip via .distignore (Required §12)
* Fixed: Broken href on admin footer credit link (WPB_AUTHOR_URL was not properly interpolated)
* Added: Focus/keyboard navigation styles for all interactive elements (a, button, inputs, nav-link, .btn)
* Verified: All $_POST accesses sanitized and nonce-protected (Fix #6)
* Verified: No front-end credit links beyond style.css Author URI (Fix #5)
* Verified: editor-style.css exists and registered via add_editor_style() (Fix #4)
* Verified: add_theme_support('title-tag') present (Fix #3)

= 1.0.3 =
* Added: One-click Demo Content Importer (Appearance → Demo Content)
* Added: 4 pages, 6 posts, nav menu, widget setup, customizer presets via importer
* Added: GD-generated placeholder images — no external HTTP required
* Added: Shortcode-aware demo content (uses [wpb_*] when companion plugin active)
* Added: Clean reset — all demo content tagged _wpb_demo=1 for complete removal

= 1.0.1 =
* Fixed: Admin bar overlapping sticky header — header now correctly positioned below admin bar (32px desktop / 46px mobile)
* Fixed: Customizer CSS output with null-safe hex color fallbacks
* Added: Selective refresh partials for site title, tagline, logo, hero, footer copyright
* Improved: Customizer live preview JS for colours, hero, and font size

= 1.0.0 =
* Initial production release

== Credits ==

Theme by WPWiseBones — https://wprealwise.com
Bootstrap 5 — https://getbootstrap.com (MIT License)
Bootstrap Icons — https://icons.getbootstrap.com (MIT License)
