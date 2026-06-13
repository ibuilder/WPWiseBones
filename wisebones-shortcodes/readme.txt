=== WiseBones Shortcodes ===
Contributors:      wpwisebones
Tags:              shortcodes, bootstrap, bootstrap-5, cards, accordion
Requires at least: 6.0
Tested up to:      7.0
Stable tag:        1.0.2
Requires PHP:      8.0
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Companion shortcodes plugin for the WPWiseBones Bootstrap 5 WordPress theme. Adds 17 Bootstrap shortcodes.

== Description ==

WPWiseBones Shortcodes is the official companion plugin for the [WPWiseBones](https://wprealwise.com/wpwisebones) Bootstrap 5 WordPress theme.

It adds **17 Bootstrap 5 shortcodes** you can use anywhere in posts, pages, or widgets — even with other themes.

**Shortcodes included:**

* `[wpb_alert]` — Dismissible Bootstrap alert (success/danger/warning/info)
* `[wpb_button]` — Button with variant, size, and Bootstrap Icon support
* `[wpb_card]` — Bootstrap card with image, title, body, and button
* `[wpb_accordion]` / `[wpb_accordion_item]` — Collapsible FAQ accordion
* `[wpb_tabs]` / `[wpb_tab]` — Tabbed content (tabs, pills, underline styles)
* `[wpb_row]` / `[wpb_col]` — Bootstrap 12-column responsive grid
* `[wpb_cta]` — Call-to-action banner with gradient and dual buttons
* `[wpb_icon_box]` — Icon + heading + text feature box (Bootstrap Icons)
* `[wpb_progress]` — Animated progress bar with label and percentage
* `[wpb_testimonial]` — Testimonial block with star rating and avatar
* `[wpb_countdown]` — Live JavaScript countdown timer
* `[wpb_posts]` — Bootstrap card grid of posts from a query
* `[wpb_modal]` — Bootstrap modal popup with trigger button
* `[wpb_badge]` — Inline Bootstrap badge / label
* `[wpb_divider]` — Styled horizontal rule with optional text
* `[wpb_map]` — Responsive iframe map embed
* `[wpb_contact_info]` — Contact info list with icons

**Companion theme:**

Install the free [WPWiseBones theme](https://wprealwise.com/wpwisebones) for the full Bootstrap 5 experience. The theme detects whether this plugin is active and shows a one-click install prompt when it is not.

Built and maintained by [wprealwise.com](https://wprealwise.com).

== Installation ==

1. Upload the `wisebones-shortcodes` folder to `/wp-content/plugins/`
2. Activate via **Plugins > Installed Plugins**
3. Use any shortcode in your posts, pages, or widgets

Alternatively, install the WPWiseBones theme and use the one-click install prompt in the dashboard.

== Frequently Asked Questions ==

= Does this plugin require the WPWiseBones theme? =

No. The shortcodes work with any theme that loads Bootstrap 5. However, they are styled and tested to work best with the WPWiseBones theme.

= Where can I find the shortcode reference? =

After activation, go to **Plugins > WPWiseBones Shortcodes** in the WordPress admin for the full reference table.

= Is Bootstrap 5 included? =

No. Bootstrap 5 must be enqueued by your theme. The WPWiseBones theme includes Bootstrap 5 automatically.

= Is this plugin free? =

Yes, it is free and open-source (GPL-2.0-or-later).

== Screenshots ==

1. Shortcode reference page in the WordPress admin.
2. Example shortcodes rendered on the front end with the WPWiseBones theme.

== Changelog ==

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
* Initial release — 17 Bootstrap 5 shortcodes
* Admin shortcode reference page (Plugins > WPWiseBones Shortcodes)
* Theme detection notice with one-click install link

== Upgrade Notice ==

= 1.0.1 =
Minor bug fix: admin notice link rendering.

= 1.0.0 =
Initial release.