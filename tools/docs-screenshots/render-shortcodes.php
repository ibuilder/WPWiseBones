<?php
/**
 * Renders every shortcode in the WiseBones Shortcodes plugin, using the real
 * plugin callbacks, into one demo page plus a JSON manifest consumed by the
 * documentation build.
 *
 * Included by render.php (expects $repo, $out_dir, $ph in scope).
 *
 * @package WPWiseBones\Tools
 */

global $wp_stub, $shortcode_tags;

$plugin_dir             = "$repo/wisebones-shortcodes";
$wp_stub['plugin_uri']  = "file://$plugin_dir/";
$wp_stub['posts']       = wpb_sample_posts( $ph );
$wp_stub['post']        = $wp_stub['posts'][0];

require_once "$plugin_dir/wisebones-shortcodes.php";

$vendor = "file://$plugin_dir/assets/vendor";

/* Demo snippets — each is the exact shortcode a user would type. */
$demos = array(
	array(
		'slug'  => 'alert',
		'tag'   => 'wpb_alert',
		'title' => 'Alert',
		'blurb' => 'Contextual Bootstrap alert with an optional icon, bold heading and dismiss button.',
		'code'  => '[wpb_alert type="success" icon="bi-check-circle" heading="Saved." dismissible="true"]Your theme options were updated.[/wpb_alert]
[wpb_alert type="warning" icon="bi-exclamation-triangle"]Bootstrap 5 is required for these components.[/wpb_alert]',
	),
	array(
		'slug'  => 'button',
		'tag'   => 'wpb_button',
		'title' => 'Button',
		'blurb' => 'Bootstrap button with variant, size, icon and target control.',
		'code'  => '[wpb_button url="/pricing/" style="primary" size="lg" icon="bi-rocket-takeoff"]Start free[/wpb_button]
[wpb_button url="/docs/" style="outline-secondary" icon="bi-book" icon_pos="right"]Read the docs[/wpb_button]',
	),
	array(
		'slug'  => 'card',
		'tag'   => 'wpb_card',
		'title' => 'Card',
		'blurb' => 'Image, title, subtitle, body, button and footer in a Bootstrap card.',
		'code'  => '[wpb_row gutter="4"]
[wpb_col size="6"][wpb_card title="Investor tools" subtitle="NPV · IRR · DSCR" image="' . $ph['a'] . '" btn_text="Explore" btn_url="/features/" footer="Updated March 2025"]Underwrite a deal in seconds instead of a spreadsheet afternoon.[/wpb_card][/wpb_col]
[wpb_col size="6"][wpb_card title="Agent portal" subtitle="Front-end dashboard" image="' . $ph['b'] . '" btn_text="Explore" btn_url="/features/" btn_style="success"]Give each agent their listings and leads without wp-admin access.[/wpb_card][/wpb_col]
[/wpb_row]',
	),
	array(
		'slug'  => 'accordion',
		'tag'   => 'wpb_accordion',
		'title' => 'Accordion',
		'blurb' => 'Collapsible FAQ list built from [wpb_accordion_item] children.',
		'code'  => '[wpb_accordion]
[wpb_accordion_item title="Do I need the shortcodes plugin?" open="true"]No — the theme works on its own. The plugin adds the 17 [wpb_*] components.[/wpb_accordion_item]
[wpb_accordion_item title="Does it work with other Bootstrap 5 themes?"]Yes. Bootstrap is auto-loaded only when the active theme does not already provide it.[/wpb_accordion_item]
[wpb_accordion_item title="Is it translation ready?"]Yes, every string is wrapped in the plugin text domain.[/wpb_accordion_item]
[/wpb_accordion]',
	),
	array(
		'slug'  => 'tabs',
		'tag'   => 'wpb_tabs',
		'title' => 'Tabs',
		'blurb' => 'Tabbed panes in tabs, pills or underline style.',
		'code'  => '[wpb_tabs style="pills"]
[wpb_tab title="Overview" icon="bi-house" active="true"]A Bootstrap 5 starter theme with the full WordPress template hierarchy.[/wpb_tab]
[wpb_tab title="Install" icon="bi-download"]Upload the theme zip, activate, then install the companion plugin when prompted.[/wpb_tab]
[wpb_tab title="Support" icon="bi-life-preserver"]Open an issue on GitHub with your WordPress and PHP version.[/wpb_tab]
[/wpb_tabs]',
	),
	array(
		'slug'  => 'columns',
		'tag'   => 'wpb_row',
		'title' => 'Row & columns',
		'blurb' => 'The Bootstrap 12-column grid with responsive breakpoint attributes.',
		'code'  => '[wpb_row gutter="3"]
[wpb_col size="4" class="p-3 bg-primary-subtle rounded"]size="4"[/wpb_col]
[wpb_col size="4" class="p-3 bg-success-subtle rounded"]size="4"[/wpb_col]
[wpb_col size="4" class="p-3 bg-warning-subtle rounded"]size="4"[/wpb_col]
[/wpb_row]
[wpb_row gutter="3" class="mt-3"]
[wpb_col size="8" class="p-3 bg-info-subtle rounded"]size="8"[/wpb_col]
[wpb_col size="4" class="p-3 bg-secondary-subtle rounded"]size="4"[/wpb_col]
[/wpb_row]',
	),
	array(
		'slug'  => 'cta',
		'tag'   => 'wpb_cta',
		'title' => 'Call to action',
		'blurb' => 'Full-width gradient banner with one or two buttons.',
		'code'  => '[wpb_cta heading="Ready to build?" subtext="Install the theme and the shortcodes plugin in under two minutes." btn_text="Download" btn_url="/download/" btn2_text="See the docs" btn2_url="/docs/"]',
	),
	array(
		'slug'  => 'icon-box',
		'tag'   => 'wpb_icon_box',
		'title' => 'Icon box',
		'blurb' => 'Bootstrap Icon, heading and text — the standard feature grid cell.',
		'code'  => '[wpb_row gutter="4"]
[wpb_col size="4"][wpb_icon_box icon="bi-speedometer2" title="Fast" color="primary"]No page builder, no jQuery — just Bootstrap 5 and the WordPress template hierarchy.[/wpb_icon_box][/wpb_col]
[wpb_col size="4"][wpb_icon_box icon="bi-shield-check" title="Review ready" color="success"]Escaped output and sanitised settings throughout.[/wpb_icon_box][/wpb_col]
[wpb_col size="4"][wpb_icon_box icon="bi-translate" title="Translatable" color="danger"]Every string carries the theme or plugin text domain.[/wpb_icon_box][/wpb_col]
[/wpb_row]',
	),
	array(
		'slug'  => 'progress',
		'tag'   => 'wpb_progress',
		'title' => 'Progress bar',
		'blurb' => 'Labelled progress bar, optionally striped and animated.',
		'code'  => '[wpb_progress label="Templates" value="100" color="primary"]
[wpb_progress label="Customizer coverage" value="85" color="success" striped="true" animated="true"]
[wpb_progress label="WooCommerce styling" value="60" color="warning"]',
	),
	array(
		'slug'  => 'testimonial',
		'tag'   => 'wpb_testimonial',
		'title' => 'Testimonial',
		'blurb' => 'Quote with star rating, author and role.',
		'code'  => '[wpb_row gutter="4"]
[wpb_col size="6"][wpb_testimonial author="Sample Author" role="Illustrative example" stars="5"]Placeholder copy — replace with a real, attributable quote before publishing.[/wpb_testimonial][/wpb_col]
[wpb_col size="6"][wpb_testimonial author="Sample Author" role="Illustrative example" stars="4"]Placeholder copy — the component renders the stars, avatar and role you pass in.[/wpb_testimonial][/wpb_col]
[/wpb_row]',
	),
	array(
		'slug'  => 'countdown',
		'tag'   => 'wpb_countdown',
		'title' => 'Countdown',
		'blurb' => 'Live JavaScript countdown to a date, rendered server-side then ticked in the browser.',
		'code'  => '[wpb_countdown date="2026-12-31 23:59:59" label="Launch countdown"]',
	),
	array(
		'slug'  => 'posts',
		'tag'   => 'wpb_posts',
		'title' => 'Post grid',
		'blurb' => 'A WP_Query post grid with thumbnails, excerpt and meta.',
		'code'  => '[wpb_posts count="3" columns="3" excerpt="18"]',
	),
	array(
		'slug'  => 'modal',
		'tag'   => 'wpb_modal',
		'title' => 'Modal',
		'blurb' => 'Trigger button plus a Bootstrap modal containing your content.',
		'code'  => '[wpb_modal id="demoModal" title="Theme options" btn_text="Open the modal" size="lg"]Layout, hero, colours and performance toggles all live under Appearance → Theme Options.[/wpb_modal]',
	),
	array(
		'slug'  => 'badge',
		'tag'   => 'wpb_badge',
		'title' => 'Badge',
		'blurb' => 'Inline badge or pill label.',
		'code'  => '[wpb_badge type="primary"]New[/wpb_badge] [wpb_badge type="success" pill="true"]Stable[/wpb_badge] [wpb_badge type="warning" pill="true"]Beta[/wpb_badge] [wpb_badge type="dark"]GPL-2.0[/wpb_badge]',
	),
	array(
		'slug'  => 'divider',
		'tag'   => 'wpb_divider',
		'title' => 'Divider',
		'blurb' => 'Rule with optional centred label and border style.',
		'code'  => '[wpb_divider text="OR" style="dashed" spacing="3"]',
	),
	array(
		'slug'  => 'map',
		'tag'   => 'wpb_map',
		'title' => 'Map embed',
		'blurb' => 'Responsive iframe wrapper for a map embed URL.',
		'code'  => '[wpb_map src="https://www.openstreetmap.org/export/embed.html?bbox=-0.16,51.49,-0.10,51.52&layer=mapnik" height="320"]',
	),
	array(
		'slug'  => 'contact-info',
		'tag'   => 'wpb_contact_info',
		'title' => 'Contact info',
		'blurb' => 'Icon list of phone, email, address and opening hours.',
		'code'  => '[wpb_contact_info phone="+1 555 0100" email="hello@example.com" address="123 Main Street, Springfield" hours="Mon–Fri, 9–5"]',
	),
);

/* ── Attribute tables, read straight from the shortcode sources ──────── */

function wpb_extract_atts( string $file ): array {
	$src = (string) file_get_contents( $file );
	$out = array();
	if ( preg_match_all( '/shortcode_atts\(\s*array\((.*?)\),\s*\$atts/s', $src, $blocks ) ) {
		foreach ( $blocks[1] as $i => $block ) {
			$pairs = array();
			if ( preg_match_all( "/'([a-z0-9_]+)'\s*=>\s*(.+?),\s*(?:\/\/(.*))?\n/i", $block, $m, PREG_SET_ORDER ) ) {
				foreach ( $m as $row ) {
					$default = trim( $row[2] );
					$default = preg_replace( "/^__\(\s*'(.*)',.*\)$/", '$1', $default );
					$default = trim( $default, "'\" " );
					$pairs[] = array(
						'name'    => $row[1],
						'default' => '' === $default ? '—' : $default,
						'note'    => isset( $row[3] ) ? trim( $row[3] ) : '',
					);
				}
			}
			$out[] = $pairs;
		}
	}
	return $out;
}

$sources = array(
	'alert' => 'sc-alert.php', 'button' => 'sc-button.php', 'card' => 'sc-card.php',
	'accordion' => 'sc-accordion.php', 'tabs' => 'sc-tabs.php', 'columns' => 'sc-columns.php',
	'cta' => 'sc-cta.php', 'icon-box' => 'sc-icon-box.php', 'progress' => 'sc-progress.php',
	'testimonial' => 'sc-testimonial.php', 'countdown' => 'sc-countdown.php', 'posts' => 'sc-posts.php',
	'modal' => 'sc-modal.php', 'badge' => 'sc-badge.php', 'divider' => 'sc-divider.php',
	'map' => 'sc-map.php', 'contact-info' => 'sc-contact-info.php',
);

/* ── Render the demo page ────────────────────────────────────────────── */

$manifest = array();
$body     = '';

/* Local placeholder paths are fine for rendering, but the documented snippet
   should show a URL a reader could actually type. */
$display_swap = array(
	$ph['a'] => 'https://example.com/investor-tools.jpg',
	$ph['b'] => 'https://example.com/agent-portal.jpg',
	$ph['c'] => 'https://example.com/sample-three.jpg',
	$ph['d'] => 'https://example.com/sample-four.jpg',
);

foreach ( $demos as $demo ) {
	$html      = do_shortcode( $demo['code'] );
	$body     .= '<section class="shot-wrap"><div class="shot" id="shot-' . $demo['slug'] . '" data-slug="' . $demo['slug'] . '">' . $html . '</div></section>' . "\n";
	$atts_file = "$plugin_dir/shortcodes/" . $sources[ $demo['slug'] ];
	$manifest[] = array(
		'slug'  => $demo['slug'],
		'tag'   => $demo['tag'],
		'title' => $demo['title'],
		'blurb' => $demo['blurb'],
		'code'  => strtr( $demo['code'], $display_swap ),
		'atts'  => file_exists( $atts_file ) ? wpb_extract_atts( $atts_file ) : array(),
	);
}

$page = '<!doctype html><html lang="en"><head><meta charset="utf-8">'
	. '<meta name="viewport" content="width=device-width, initial-scale=1">'
	. '<title>WiseBones Shortcodes — rendered demos</title>'
	. '<link rel="stylesheet" href="' . $vendor . '/bootstrap/css/bootstrap.min.css">'
	. '<link rel="stylesheet" href="' . $vendor . '/bootstrap-icons/css/bootstrap-icons.min.css">'
	. '<link rel="stylesheet" href="file://' . $repo . '/wpwisebones/style.css">'
	. '<link rel="stylesheet" href="file://' . $repo . '/wpwisebones/assets/css/main.css">'
	. '<style>body{background:#fff;margin:0;padding:0}'
	. '.shot-wrap{padding:28px}.shot{background:#fff;width:900px}'
	. '.wpb-icon-box .icon{font-size:2.25rem;line-height:1}'
	. '</style></head><body>' . $body
	. '<script src="' . $vendor . '/bootstrap/js/bootstrap.bundle.min.js"></script>'
	. '<script src="file://' . $plugin_dir . '/assets/js/wpbs-countdown.js"></script>'
	. '</body></html>';

file_put_contents( "$out_dir/shortcodes.html", $page );
file_put_contents( "$out_dir/shortcodes.json", json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );

fwrite( STDOUT, 'Rendered ' . count( $demos ) . " shortcode demos → $out_dir/shortcodes.html\n" );
