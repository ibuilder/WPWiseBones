=== Antivig ===
Contributors: antivig
Requires at least: 6.5
Tested up to: 6.7
Requires PHP: 8.1
Stable tag: 0.4.2
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: sports, membership, bootstrap, light, dark

Child theme of WPWiseBones for Antivig: the brand, the board typography, and the member chrome.

== Description ==

Antivig is a child theme of WPWiseBones. It supplies the visual identity for a
paid sports-analysis membership and nothing else — the odds board, the pick
ledger and the membership gate all live in plugins, so the site keeps working
if the theme is swapped.

What the theme owns:

* **Tokens.** A `--avt-*` custom-property layer with matched light and dark
  palettes. The prefix is deliberate: the membership plugin publishes its own
  `--av-*` tokens for themes to retint, and several names collide semantically
  (the plugin's `--av-ink` is "text colour" and flips in dark mode; the brand's
  ink is always scoreboard navy).
* **Typography.** Saira Condensed for display, IBM Plex Sans for text, IBM Plex
  Mono for prices. Prices are the one thing on this site that must line up in a
  column, so the numeric faces are tabular throughout.
* **The front page,** which explains what devigging is to somebody who has never
  placed a bet, using a worked example rather than a claim.
* **Navigation and footer,** including the compliance line that has to appear on
  every page: analysis, not advice; no wagering; 21+.

= Requirements =

* WPWiseBones (parent theme).
* PHP 8.1 or later.

== Resources ==

Every bundled asset, with its licence. Fonts are self-hosted as WOFF2 under
`assets/fonts/` rather than linked from a CDN, so no visitor's IP address
reaches a third party in order to render a page.

* Saira Condensed, by Omnibus-Type — SIL Open Font License 1.1 —
  https://fonts.google.com/specimen/Saira+Condensed
* IBM Plex Sans, by IBM — SIL Open Font License 1.1 —
  https://fonts.google.com/specimen/IBM+Plex+Sans
* IBM Plex Mono, by IBM — SIL Open Font License 1.1 —
  https://fonts.google.com/specimen/IBM+Plex+Mono
* screenshot.png — original work, GPLv2 or later, composed from the theme's own
  palette and typefaces.
* The Antivig wordmark and chevron — original work, GPLv2 or later.

== Changelog ==

= 0.4.2 =
* WPWiseBones 1.0.13 enqueues its own style.css and prints this theme's after
  it, so the workaround that pinned the cascade by hand now runs only on older
  parents. On 1.0.13 it would have printed the parent stylesheet twice and
  stamped this theme's version on the parent's copy.

= 0.4.1 =
* The front page no longer lists model probabilities as a membership benefit
  (Market view).

= 0.4.0 =
* **Installable web app** (#25). A manifest, app icons and a service worker let
  members add Antivig to a phone's home screen. The worker never stores a page —
  member pages are personal — and shows a self-contained offline page only when
  the network is gone. Web push is not included yet.

= 0.3.5 =
* The board's best price no longer carries the accent colour, which made the
  underdog's bigger number look like the recommendation.

= 0.3.4 =
* Style the compliance notice the membership plugin puts above the sign-up form.


= 0.3.3 =
* The site-wide call to action pointed at /pricing/, a page that has never
  existed — a 404 on every page of the site, on the one link the business runs
  on. Page URLs now come from the plugin that created the page.
* The footer's Privacy link pointed at a draft, which is a 404 for anyone not
  signed in. Menu items are reconciled on every pass and only published pages
  are linked; an item left pointing at an unpublished page is removed.


= 0.3.2 =
* Text domain matches the folder, so translations actually load.
* Theme screenshot, and a readme with the bundled resources declared.
* The membership call-to-action is no longer registered as a shortcode: it was
  never used as one, and content that depends on the theme breaks when the theme
  changes.
* Core's emoji polyfill is dequeued — 11 KB of script on every page for browsers
  that stopped existing a decade ago.

= 0.3.0 =
* Front page: hero, worked example, how it works, the promise, the CTA.
* Navigation and footer menus built once on activation.
* Self-hosted fonts.
