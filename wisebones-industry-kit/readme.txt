=== WiseBones Industry Kit ===
Contributors: wprealwise
Tags: real estate, construction, contractor, listings, lead form
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Listings, projects, services, team, testimonials, lead forms, schema markup and a one-click starter site for real estate and construction businesses.

== Description ==

The companion plugin for the WPWiseBones child theme library. The theme decides
which content types a site needs; the plugin provides them, so your content
stays put if you ever change theme.

**Content types** (each switched on by the active theme, or by you):

* Listings — status, price, beds, baths, floor area, units, lot, address, MLS #, virtual tour; property types
* Projects — client, location, year, value, size, duration, role, status; sectors
* Services — icon and starting price
* Team — role, license / NMLS number, phone, email
* Testimonials — client name, detail and rating (never shown publicly unless you publish them)
* Service areas — shared across listings, projects, services and team

**Lead forms** — `[wbik_lead_form type="…"]` with seven ready-made types:
contact, quote, showing, valuation, prequal, owner, order. Every lead is stored
under Leads and emailed to you. Spam protection is built in (nonce, honeypot,
signed timestamp, per-visitor rate limit) with no third-party service.

**Schema markup** — your business as RealEstateAgent, GeneralContractor,
RoofingContractor, HVACBusiness, Plumber, Electrician, FinancialService,
ProfessionalService or HomeAndConstructionBusiness on the front page, and
RealEstateListing with an Offer on each listing.

**Starter site** — Appearance → Starter Site builds the active industry theme's
pages, menu, services and service areas, and can be removed again in one click.
Existing pages are never overwritten.

**Shortcodes** — `[wbik_listings status="for-sale" count="6"]`,
`[wbik_projects sector="healthcare"]`, `[wbik_services]`, `[wbik_team]`,
`[wbik_testimonials]`, `[wbik_areas]`. Each takes `count`, `columns` and `area`.

Works with any theme; looks its best with a WPWiseBones industry child theme,
whose card templates the grids reuse.

== Frequently Asked Questions ==

= Which theme do I need? =

None in particular. With a WPWiseBones industry child theme active, the content
types, schema type and default lead form follow the theme. Otherwise choose
them on Settings → Industry Kit.

= Where do leads go? =

To the email on Settings → Industry Kit (or the site admin email), and into the
Leads screen. Hook `wbik_lead_received` to forward them to a CRM.

= Does it import MLS / IDX feeds? =

No. Listings are entered by hand or through the REST API (every field is
registered with `show_in_rest`).

== Changelog ==

= 1.0.0 =
* Initial release.
