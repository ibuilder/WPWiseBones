# Becoming

A trans-pride child theme of **WPWiseBones**, built for the community platform
where trans women document and fund a transition. It styles the site chrome and
every `tw-*` module shortcode — journey, photos, funding, verification,
resources, safety and Look Lab.

| | |
|---|---|
| Template | `wpwisebones` |
| Text domain | `becoming` |
| Brand CSS | `assets/css/becoming.css` |
| JavaScript | `assets/js/becoming.js` — colour-scheme memory only |
| Templates overridden | `header.php` only |
| Third-party requests | none |

---

## The colour decision

The trans flag is sky `#5BCEFA`, rose `#F5A9B8` and white. Measured against
white those come out at **1.80:1** and **1.87:1**. As text, as a link colour or
as a thin outline on a white card they are illegible, so a theme that simply
sets `a { color: #F5A9B8 }` looks like the flag in a screenshot and fails
anyone reading it on a phone in daylight.

Measured the other way round they are excellent:

| Pair | Ratio | |
|---|---|---|
| Flag rose as text on white | 1.87:1 | fails |
| Flag sky as text on white | 1.80:1 | fails |
| Plum ink `#16121A` on flag rose | 9.91:1 | AAA |
| Plum ink on flag sky | 10.26:1 | AAA |
| Flag sky on plum `#0D0A12` | 10.90:1 | AAA |
| Flag rose on plum | 10.52:1 | AAA |
| Link `#0B5F85` on white | 7.02:1 | AAA |
| Accent `#B21F49` on white | 6.59:1 | AA |

So **light mode uses the flag colours as surfaces** — buttons, stripes,
gradients, washes — with plum ink on top, and darkens them for anything that
has to be text. **Dark mode uses the flag colours as themselves**, which makes
the dark theme the more faithful of the two.

Every pair above was computed, not eyeballed. If you change a colour, compute
the new ratio before shipping it.

## Two places the theme is deliberately not "hot"

1. **`.tw-crisis`, and the panic and lockdown controls.** No gradient, no glow,
   no animation, no hover lift. Someone reaching for those is not browsing.
   They are styled for one quality: being found instantly and read without
   effort. Phone numbers are set in a monospace face at a larger size, because
   digits that blur together are useless to someone whose hands are shaking.
2. **No webfont.** The sibling children (RealWise, AEC Forge) pull Plus Jakarta
   Sans from Google Fonts. That hands every visitor's IP to a third party on
   every page view, and on a site where some members are hiding from someone
   that is a safety question rather than a performance one. The display face is
   a modern system stack. There is a commented opt-in block at the end of
   `becoming.css` if you decide otherwise — self-host the files.

## Nothing you have to hit is smaller than 44px

Measured at 375px, not estimated. Before the pass: filter checkboxes 17×17,
the burger 40×29, the colour-scheme button 34×31, footer links 20px tall,
every submit button 41px — and the **crisis phone numbers at 24×19**.

That last one is the one to remember. The typography was already right: the
numbers are monospace and set large, because digits that blur together are
useless to someone whose hands are shaking. The *target* was the smallest
thing on the page. Getting the type right and the hit area wrong is easy,
because the type is what you look at when you check your work.

The floor sits in `tw-front.css` (checkboxes to 24px, the WCAG 2.2 minimum,
so it holds with no theme installed) and the comfortable size here (44px on
labels, buttons, nav links and contact links). Nothing changed what any
control does.

The skip link is part of this. It appears on focus — that was working — but it
appeared as WordPress's default `#ddd` box inheriting this theme's sky link
colour: **1.33:1**, visible and unreadable. It is now the flag sky with
`--bc-btn-ink` on it, 10.26:1, which is the same surface-not-text rule as
everything else here.

## Things worth knowing before you edit

### A child's `style.css` replaces the parent's entirely

The parent enqueues `get_stylesheet_uri()` under the handle
`wpwisebones-style`, which resolves to the **child's** `style.css` once a child
is active. The parent's own 356-line `style.css` is therefore never loaded —
only its `assets/css/main.css` is. Header positioning, `#back-to-top`, the
landing template, the admin-bar offsets: all of it has to be restated in the
child. See the section *Chrome this child now owns* in `becoming.css`.

Both sibling children are in the same position.

### The parent's real style handles

The handles are `wpwisebones-style` and `wpwisebones-main`. RealWise declares a
dependency on `wpb-main`, which is not registered anywhere in the parent, so
that dependency silently never resolves and its stylesheet is ordered only by
its hook priority. `functions.php` here depends on the real handles and checks
each one before using it.

### `tw-front.css` is forced into the `<head>`

tw-core registers its front-end floor lazily — the first `tw-*` shortcode to
render calls `tw_enqueue_front_styles()`, which happens during `the_content`,
long after `wp_head`. WordPress then emits it in the footer, and **a stylesheet
in the footer wins every tie against one in the head**. That would mean the
floor silently overriding the theme on exactly the components the theme most
wants to style.

`functions.php` calls `tw_enqueue_front_styles()` during `wp_enqueue_scripts`
so it lands in the head ahead of the brand stylesheet and the cascade runs
floor → theme. The cost is one small stylesheet on pages with no `tw-*`
shortcode. If you ever see a tw- component ignoring this theme, check that
ordering first.

### One `<h1>` per page

`becoming_pagehead()` prints the page title, and the parent's
`content-page.php` prints another. Rather than hiding the second in CSS — which
leaves it in the accessibility tree, so a screen reader announces the heading
twice while a sighted visitor sees it once — the theme filters the parent's own
`_wpwisebones_hide_title` post meta, which removes it from the markup.

### Full width by default

The parent defaults to a right sidebar, and `wpwisebones_has_sidebar()` returns
true on **any** singular page whether or not the sidebar holds a single widget.
So emptying the sidebar does not collapse it — it takes a third of the page and
leaves it blank while the content sits in `col-lg-8`. Every page on this
platform is a grid, so the theme defaults `wpwisebones_layout` to `full-width`.
An explicit choice in the customizer still wins: the filter reads
`get_theme_mods()` directly, because the filtered value cannot tell "never set"
from "deliberately set to right-sidebar".

### The nav walker drops custom menu classes

`WPWISEBONES_Bootstrap_Nav_Walker` builds its `<li>` class string from scratch
and never reads `$item->classes`, so anything typed into the **CSS Classes**
field in Appearance → Menus is silently discarded — and `nav_menu_css_class`
has nothing to act on either. `Becoming_Nav_Walker` keeps the parent's markup
and adds those classes back, and `becoming_primary_nav()` renders with it,
since the parent hardcodes its own walker with no filter to swap it through.
The subclass is declared on `after_setup_theme`, because WordPress loads the
**child's** `functions.php` first — `extends` at the top level would fatal.

### Help is top-level and childless, on purpose

A Bootstrap `dropdown-toggle` swallows the first click to open its menu. Making
Help a dropdown parent would mean the one page somebody might be opening in a
hurry no longer opens on the first click. Related pages (the demo index,
Suggest a resource) went to the footer menu instead, and the item carries a
`bc-nav-help` class so it reads as distinct without being a dropdown.

### Section navigation comes from the menu, not from a setting

A page inside a dropdown group prints its siblings under the title, so moving
from *My journey* to *Milestones* is one click instead of reopening the
dropdown you just closed — two deliberate actions, and on a phone both of them
behind the burger.

`becoming_section()` reads the primary menu, finds the item pointing at the
current page and returns its siblings. There is no second place to configure
sections: they are whatever **Appearance → Menus** says they are, so nothing
can drift out of sync.

It prints nothing for a top-level item with no children — Help, Safety, Look
Lab — because a row containing one link is furniture, not navigation. It also
prints nothing on a page that is not in the menu at all, such as the demo
index.

The current page is marked twice over: the flag gradient for a glance, and
`aria-current="page"` for anyone the gradient never reaches. The ink on that
pill is `--bc-btn-ink`, because the flag colours work as a surface with dark
ink on top and fail as text — the whole colour decision of this theme in one
component.

The row scrolls inside itself rather than wrapping. A section has two or three
items so it almost never does, but a long pair of titles on a 320px phone must
not be the thing that puts a horizontal scrollbar on the document.

### `header.php` is the only template override

Three structural reasons: the flag hairline and aurora need real elements, the
colour-scheme control has to sit in the header, and the parent's burger is a
background-image tinted for light navbars that vanishes on the dark canvas. The
footer needed no override — its flag stripe is a `::before`, which was a better
trade than forking 90 lines of template.

The parent exposes exactly one `do_action` in its entire template tree, and it
is `wp_enqueue_scripts`, so there was no hook to use instead.

## Bugs this theme hit while being built, and what they teach

- **The aurora put 190px of horizontal scroll on every page.** It had a
  negative horizontal inset so the glow could bleed past the section edges. Its
  own `overflow: hidden` clips the blobs *inside* it — not the element itself.
  `body { overflow-x: clip }` hid the symptom. The fix is `overflow: clip` on
  the section plus a mask for the soft edge: decoration is contained by the
  thing it decorates.
- **`border-image` has no per-side form.** `border: 1px solid; border-left: 3px
  solid transparent; border-image: <gradient> 1` draws a gradient frame right
  round the element rather than a stripe down one edge, and cancels
  `border-radius` while it is at it. Accent stripes here are backgrounds sized
  to 3px.
- **`align-items: end` flips meaning with `flex-direction`.** The floor turns
  filter rows into flex containers that go to `column` under 480px. An
  `align-items: end` meant to bottom-align a submit button aligned every label
  to the right edge on a phone. It is now guarded by `@media (min-width: 481px)`.
- **`.tw-journey-library form` matched nothing it was meant to.** The library
  ships no filter form, so the only thing that selector ever hit was the status
  form inside each milestone card — giving it a second box inside the card it
  already sat in. Check what a selector actually matches in a rendered page.
- **Dropping `navbar-expand-lg` hid the whole menu.** Bootstrap's
  `.collapse:not(.show) { display: none }` only yields to the
  `display: flex !important` that `navbar-expand-*` supplies above the
  breakpoint. Without those classes on the header, the navigation stayed behind
  the burger on a 1200px desktop. They are load-bearing, not decoration.
- **A descendant selector opened every dropdown at once.**
  `.main-navigation ul` also matches each `.dropdown-menu` nested in the nav,
  so it handed them `display: flex` and beat Bootstrap's `display: none` —
  every dropdown on the site rendered open, stacked on top of each other.
  `.main-navigation a` did the same to `.dropdown-item`. Nav rules here use
  child combinators.

## Verified

- All 12 module pages plus the demo index: no horizontal overflow at 375px,
  exactly one `<h1>` each, no empty sidebar column.
- Navigation: expands at desktop with the toggler hidden, collapses to the
  burger below 992px; exactly one dropdown opens at a time; groups open inline
  and indented inside the collapsed menu.
- `tw-front.css` loads in the head, before `becoming.css`.
- Sticky header clears the WordPress admin bar at both 32px and 46px.
- The colour-scheme toggle persists in `localStorage` and overrides the system
  preference; with JavaScript off, `prefers-color-scheme` still applies.
- Sandbox `debug.log` clean of anything from this theme.

## Not done

- `screenshot.png` is a generated flag wash, not a capture of a real page.
  Replace it with a screenshot of the live site when there is one worth
  showing.
- Not tested against the parent's WooCommerce templates.
- `front-page.php` is deliberately not overridden, so the front page renders
  whatever page is assigned to it.
