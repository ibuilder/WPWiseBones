=== WPWiseBones ===
Contributors:      wpwisebones
Requires at least: 6.0
Tested up to:      7.0
Stable tag:        1.0.9
Requires PHP:      7.4
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

WPWiseBones is a comprehensive, production-ready WordPress starter theme
built on Bootstrap 5.3. It ships with everything a professional developer or
agency needs out of the box â€” shortcodes, custom widgets, a full admin options
panel, the Customizer, Open Graph SEO, WooCommerce support, and more.

Built and maintained by WPWiseBones.com â€” https://wprealwise.com

== Features ==

Bootstrap 5 (local vendor by default; CDN opt-in via WPWISEBONES_LOCAL_ASSETS constant)
Bootstrap Icons 1.11
theme.json for block editor color/font/layout sync
3 Custom Widgets
7 Widget Areas (Sidebar, 4x Footer columns, Header, Before/After Content, Shop)
Customizer: colors, Google Fonts, layout, header, hero, footer, social links
Admin Options page (Appearance â†’ Theme Options): preloader, breadcrumbs, author box,
  related posts, reading time, social share, excerpt length, copyright text,
  custom CSS/JS, and performance toggles
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
2. Activate via Appearance â†’ Themes
3. Configure via Appearance â†’ Customize
4. Assign menus under Appearance â†’ Menus (Primary, Footer, Top Bar)
5. Add widgets under Appearance â†’ Widgets

== Local Bootstrap Assets ==

Bootstrap 5 and Bootstrap Icons are bundled in assets/vendor/ and served locally
(WP.org Guideline 8 compliance — no CDN requests).

== Development Scripts ==

  npm install          Install dependencies
  npm run sync         Re-copy Bootstrap from node_modules to assets/vendor/
  npm run pot          Regenerate .pot translation file (requires WP-CLI)
  npm run zip          Build distributable .zip
  npm run preflight    Full production readiness check

== Changelog ==

= 1.0.9 =
* Fixed: CDN fallback branches removed from enqueue.php — Bootstrap served locally only (WP.org Guideline 8)
* Fixed: wp_add_inline_style() used for customizer CSS instead of echo <style>
* Fixed: wp_add_inline_style()/wp_add_inline_script() used for custom CSS/JS from options instead of echo
* Fixed: wp_kses_post() applied to get_avatar(), get_the_post_thumbnail(), widget before/after_widget args throughout
* Fixed: ABSPATH guard added to all 15 silence index.php files in theme
* Fixed: readme.txt header block updated to standard WP.org format with all required fields
* Fixed: == Resources == section added documenting Bootstrap 5.3.3 and Bootstrap Icons 1.11.3

= 1.0.8 =
* Fixed: custom-menu tag corrected to custom-menus (plural) per WP.org approved tag list
* Fixed: global $content_width declared correctly inside wpwisebones_setup()
* Fixed: admin notice inline styles removed; uses standard WP notice classes only
* Fixed: companion notice "Learn More" link now points to wordpress.org/plugins/
* Fixed: companion plugin readme URL updated to wordpress.org
* Fixed: unescaped $cats output in content-single.php (wp_kses_post)
* Fixed: smooth scroll option uses wp_add_inline_style() instead of echo <style>
* Fixed: ABSPATH guard added to all 8 root template files
* Fixed: widget display names updated from WPB: to WPWiseBones:
* Fixed: form input name= attributes now escaped with esc_attr()
* Fixed: meta tag $content output in seo.php now escaped with esc_attr()
* Fixed: $GLOBALS['comment'] override suppressed with phpcs:ignore per WP core pattern
* Fixed: $path variable renamed to $wpwisebones_path to avoid global override warning
* Fixed: short ternaries (?:) replaced with explicit ternaries throughout
* Fixed: BOM removed from widget files and admin-page.php
* Fixed: Yoda condition in nav-menus.php
* Fixed: 698 auto-fixable WordPress coding standards violations corrected by PHPCBF

= 1.0.7 =
* Fixed: Block style names renamed from wpb- prefix to wpwisebones- prefix (Required Â§4 uniqueness)
* Fixed: Google Fonts enqueue handle renamed from wpb-google-fonts to wpwisebones-google-fonts
* Fixed: Canonical URL output removed from seo.php â€” WordPress core handles this since WP 4.6
* Fixed: 7 escaping violations in breadcrumbs and entry footer (esc_html, esc_html on
  get_the_author/date/search_query, wp_kses_post on category/tag lists)
* Fixed: JS string 'Select Image' in meta-boxes.php now passed through __() via wp_json_encode
* Fixed: Duplicate == Changelog == section removed from readme.txt
* Fixed: Requires PHP aligned to 7.4 in both style.css and readme.txt
* Fixed: Tested up to: 7.0 confirmed (WordPress 7.0 is current; prior build incorrectly set 6.8)
* Fixed: demo-importer.php reference removed from functions.php autoloader

= 1.0.6 =
* Fixed: Theme Options admin page (Appearance â†’ Theme Options) restored to submission zip
  â€” it is permitted as a sub-page under Appearance per WP.org Required Â§4
* Fixed: Capability changed from `manage_options` to `edit_theme_options` throughout
  admin page, matching WP.org Required Â§4 and the Customizer's own capability
* Fixed: Three broken `href=CONSTANT` (missing PHP echo/esc_url) in admin page template
* Fixed: Admin footer credit now checks for the correct screen ID
  (`appearance_page_wpwisebones-theme-options`) instead of a partial string match
* Fixed: Companion plugin notice now also shows on Themes and Theme Options screens
* Fixed: Removed all custom gradient/inline styles from admin page; uses core WP notice
  classes (`notice notice-success inline`, `notice notice-warning inline`) throughout
* Updated: Companion version constant updated to 1.0.3

= 1.0.5 =
* Fixed: All PHP functions, constants, options, post meta, enqueue handles, and image sizes
  renamed from wpb_/WPB_ to wpwisebones_/WPWISEBONES_ â€” prefix is now globally unique
* Fixed: Admin toolbar links removed (not allowed per WP.org Required rules)
* Fixed: Theme Options admin page excluded from submission zip (plugin territory)
* Fixed: Skip link now targets #main with tabindex="-1" and does not overlap admin bar
* Fixed: Content links (entry-content, comments, widgets) are now underlined by default
* Fixed: Mobile menu has solid background; focus is now trapped inside when open
* Fixed: Companion plugin notice limited to Plugins screen only

= 1.0.4 =
* Fixed: WPWISEBONES_LOCAL_ASSETS now defaults to true (Bootstrap served locally, Required Â§9)
* Fixed: inc/demo-importer.php excluded from WP.org submission zip (Required Â§12)
* Added: Focus/keyboard navigation styles for all interactive elements
* Verified: All post meta accesses are nonce-protected and sanitized

= 1.0.1 â€”
* Fixed: admin bar overlapping sticky header â€” header now correctly positioned below 32px admin bar on desktop and 46px on mobile
* Fixed: body padding-top adjusted for admin bar + sticky header combination
* Improved: Customizer CSS output with null-safe hex color fallbacks
* Added: Selective refresh partials for site title, tagline, logo, hero, footer copyright
* Added: Google Fonts properly enqueued via wp_enqueue_style
* Improved: Customizer live preview JS for colours, hero, font size

= 1.0.0 â€” 2025-06-06 =
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
Install: WiseBones Shortcodes
URL:     https://wordpress.org/plugins/wisebones-shortcodes/

The theme detects whether the plugin is active and:
- Shows a dismissible admin notice with a one-click install link when not installed
  (visible on Plugins, Themes, and the Theme Options screens)
- Shows plugin status in the Getting Started dashboard widget
- Shows plugin status in Appearance > Theme Options

Once installed, you get 17 shortcodes:
[wpb_alert]  [wpb_button]  [wpb_card]  [wpb_accordion]  [wpb_tabs]
[wpb_row] / [wpb_col]  [wpb_cta]  [wpb_icon_box]  [wpb_progress]
[wpb_testimonial]  [wpb_countdown]  [wpb_posts]  [wpb_modal]
[wpb_badge]  [wpb_divider]  [wpb_map]  [wpb_contact_info]

== Resources ==

This theme bundles the following open-source libraries.

**Bootstrap 5.3.3**
* Author: The Bootstrap Authors
* Source: https://github.com/twbs/bootstrap
* License: MIT License — https://github.com/twbs/bootstrap/blob/main/LICENSE
* Bundled as: assets/vendor/css/bootstrap.min.css, assets/vendor/js/bootstrap.bundle.min.js (unminified source included alongside)

**Bootstrap Icons 1.11.3**
* Author: The Bootstrap Authors
* Source: https://github.com/twbs/icons
* License: MIT License — https://github.com/twbs/icons/blob/main/LICENSE
* Bundled as: assets/vendor/css/bootstrap-icons.min.css, assets/vendor/fonts/ (unminified source included alongside)

== Credits ==

Theme by WPWiseBones â€” https://wprealwise.com
Bootstrap 5 â€” https://getbootstrap.com (MIT License)
Bootstrap Icons â€” https://icons.getbootstrap.com (MIT License)
