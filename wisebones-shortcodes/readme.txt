=== WiseBones Shortcodes ===
Contributors:      wpwisebones
Tags:              shortcodes, bootstrap, bootstrap-5, cards, accordion
Requires at least: 6.0
Tested up to:      7.0
Stable tag:        1.0.5
Requires PHP:      7.4
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

17 Bootstrap 5 shortcodes for alerts, cards, tabs, accordions, modals, countdowns, and more. Works with any theme.

== Description ==

WiseBones Shortcodes adds **17 Bootstrap 5 shortcodes** you can use anywhere in posts, pages, or widgets â€” with any WordPress theme.

Bootstrap 5 and Bootstrap Icons are bundled locally and loaded automatically when not already provided by the active theme, so the shortcodes work out-of-the-box on any WordPress installation.

**Shortcodes included:**

* `[wpb_alert]` â€” Dismissible Bootstrap alert (success/danger/warning/info)
* `[wpb_button]` â€” Button with variant, size, and Bootstrap Icon support
* `[wpb_card]` â€” Bootstrap card with image, title, body, and button
* `[wpb_accordion]` / `[wpb_accordion_item]` â€” Collapsible FAQ accordion
* `[wpb_tabs]` / `[wpb_tab]` â€” Tabbed content (tabs, pills, underline styles)
* `[wpb_row]` / `[wpb_col]` â€” Bootstrap 12-column responsive grid
* `[wpb_cta]` â€” Call-to-action banner with gradient and dual buttons
* `[wpb_icon_box]` â€” Icon + heading + text feature box (Bootstrap Icons)
* `[wpb_progress]` â€” Animated progress bar with label and percentage
* `[wpb_testimonial]` â€” Testimonial block with star rating and avatar
* `[wpb_countdown]` â€” Live JavaScript countdown timer
* `[wpb_posts]` â€” Bootstrap card grid of posts from a query
* `[wpb_modal]` â€” Bootstrap modal popup with trigger button
* `[wpb_badge]` â€” Inline Bootstrap badge / label
* `[wpb_divider]` â€” Styled horizontal rule with optional text
* `[wpb_map]` â€” Responsive iframe map embed
* `[wpb_contact_info]` â€” Contact info list with icons

**Optional companion theme:**

The free [WPWiseBones](https://wordpress.org/themes/wpwisebones/) Bootstrap 5 theme provides local Bootstrap assets, a full-page hero, custom widgets, and deep Customizer integration. The shortcodes work great with any theme, but pair especially well with WPWiseBones.

Built and maintained by [wprealwise.com](https://wprealwise.com).

== Installation ==

1. Upload the `wisebones-shortcodes` folder to `/wp-content/plugins/`
2. Activate via **Plugins > Installed Plugins**
3. Use any shortcode in your posts, pages, or widgets

Bootstrap 5 and Bootstrap Icons are loaded automatically if your theme does not already provide them.

== Frequently Asked Questions ==

= Does this plugin require a specific theme? =

No. The shortcodes work with any WordPress theme. Bootstrap 5 is loaded automatically from the jsDelivr CDN when not already enqueued by your theme.

= Where can I find the shortcode reference? =

After activation, go to **Plugins > WiseBones Shortcodes** in the WordPress admin for the full reference table.

= My theme already loads Bootstrap â€” will it be loaded twice? =

No. The plugin checks whether Bootstrap is already registered (via the `bootstrap` style/script handle) and skips loading its bundled copy if your theme already provides it.

= Is this plugin free? =

Yes, it is free and open-source (GPL-2.0-or-later).

== Screenshots ==

1. Shortcode reference page in the WordPress admin.
2. Example shortcodes rendered on the front end.

== Changelog ==

= 1.0.5 =
* Fixed: Bootstrap 5 and Bootstrap Icons now bundled locally — no CDN requests (WP.org Guideline 8 compliance)
* Fixed: Countdown script now enqueued only on pages that use [wpb_countdown], not globally
* Fixed: esc_attr() added to border-style output in sc-divider.php
* Fixed: Docblock typo [bsk_tab] corrected to [wpb_tab] in sc-tabs.php
* Added: index.php silence files to assets/ directories

= 1.0.4 =
* Fixed: Anonymous closure shortcode callbacks converted to named wpbs_sc_*() functions
* Fixed: shortcode_atts() 3rd argument (tag name) added to sc-badge, sc-divider, sc-contact-info
* Fixed: sc-badge.php used esc_html() on do_shortcode() output; now correctly uses wp_kses_post()
* Fixed: short ternaries (?:) in sc-button.php and sc-modal.php replaced with explicit ternaries
* Fixed: 698 auto-fixable WordPress coding standards violations corrected by PHPCBF

= 1.0.3 =
* Added: Bootstrap 5 and Bootstrap Icons auto-loaded from CDN when not provided by theme â€” plugin now works with any theme out-of-the-box
* Added: Self-contained countdown timer JS (assets/js/wpbs-countdown.js) â€” countdown works on any theme without requiring WPWiseBones
* Fixed: MissingTranslatorsComment PHPCS error â€” translators comment now placed directly above __() call inside wp_kses()
* Fixed: Admin notice now shows on Plugins screen only (was: Dashboard + Themes + Plugins)
* Fixed: Admin notice softened from "designed for" to "pairs with" â€” plugin works with any Bootstrap theme
* Fixed: Requires PHP lowered from 8.0 to 7.4 (no PHP 8-only syntax in use)
* Changed: Plugin description updated to reflect standalone functionality

= 1.0.2 =
* Fixed: Renamed all shortcode callback functions from wpb_sc_* to wpbs_sc_* (correct plugin prefix)
* Fixed: Renamed shared globals from wpb_ to wpbs_ prefix (accordion, tabs)
* Fixed: Loop variable $file renamed to $wpbs_file (Plugin Check NonPrefixedVariable)
* Fixed: esc_url() now inlined at output point for PHPCS OutputNotEscaped compliance

= 1.0.1 =
* Fixed: Admin notice now correctly renders theme install link as HTML
* Fixed: Cleaned up duplicate theme-detection notice registration
* Tested up to WordPress 7.0

= 1.0.0 =
* Initial release â€” 17 Bootstrap 5 shortcodes
* Admin shortcode reference page (Plugins > WiseBones Shortcodes)
* Theme detection notice with one-click install link

== Upgrade Notice ==

= 1.0.5 =
Bootstrap assets now served locally — no external CDN requests. Required for WP.org compliance.

= 1.0.4 =
Converts all shortcode callbacks to named functions for full WordPress coding standards compliance. No behavior changes.

= 1.0.3 =
Bootstrap 5 now auto-loads when not provided by theme. Countdown timer now works on any theme. Several Plugin Check compliance fixes.

= 1.0.0 =
Initial release.
