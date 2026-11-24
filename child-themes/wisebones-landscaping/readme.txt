=== WiseBones Landscaping ===
Contributors: wprealwise
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: business, portfolio, custom-colors, custom-logo, custom-menu, featured-images, full-width-template, one-column, two-columns, translation-ready

Landscaping, hardscape and outdoor-living contractor theme for WPWiseBones: design-build services, seasonal maintenance plans, a project gallery, service areas and a free-estimate form. Pair with the WiseBones Industry Kit plugin.

== Description ==

WiseBones Landscaping is part of the WPWiseBones child theme library. It needs the
WPWiseBones parent theme (1.1.0 or later) installed. It adds no PHP of its own
beyond its content config: the parent renders the front page from the sections
listed in industry-config.php, and this theme re-skins them with the tokens in
style.css.

Install the WiseBones Industry Kit plugin to get the content types (listings,
projects, services, team, testimonials, service areas), the lead forms, the
schema markup and the one-click starter site.

== Getting started ==

1. Install and activate WPWiseBones, then this theme.
2. Install and activate the WiseBones Industry Kit plugin.
3. Appearance → Starter Site → Build starter site. This creates the pages,
   main menu, services and service areas, and sets the front page.
4. Appearance → Customize → WPWiseBones → Front Page Sections: set your phone
   number, hero photo, stats and closing call to action, and switch sections
   on or off.
5. Settings → Industry Kit: business address, license number and where leads
   are emailed.

Sample entries (listings or projects, testimonials) are shown only to you while
a section is empty, each marked "Sample". Visitors never see them.

== Customizing ==

* Colors: Customizer → Brand Colours. The theme's colors are defaults only.
* Copy: hero, stats and call to action in the Customizer; everything else in
  industry-config.php, or with the `wpwisebones_industry_config` filter.
* A section's markup: copy wpwisebones/template-parts/industry/section-NAME.php
  into this theme at the same path and edit it.

== Changelog ==

= 1.0.0 =
* Initial release.

== Copyright ==

WiseBones Landscaping is distributed under the terms of the GNU GPL v2 or later.
Bootstrap Icons (MIT) are provided by the parent theme.
