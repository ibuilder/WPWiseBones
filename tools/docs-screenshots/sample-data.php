<?php
/**
 * Placeholder media and sample posts shared by the documentation renderers.
 *
 * @package WPWiseBones\Tools
 */

function wpb_placeholder( string $file, string $from, string $to, string $label = '' ): string {
	$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="500" viewBox="0 0 800 500">'
		. '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">'
		. '<stop offset="0%" stop-color="' . $from . '"/><stop offset="100%" stop-color="' . $to . '"/>'
		. '</linearGradient></defs><rect width="800" height="500" fill="url(#g)"/>'
		. '<g fill="rgba(255,255,255,.22)"><circle cx="150" cy="120" r="70"/><rect x="330" y="250" width="330" height="180" rx="18"/>'
		. '<rect x="90" y="300" width="180" height="24" rx="12"/><rect x="90" y="344" width="120" height="24" rx="12"/></g>';
	if ( $label ) {
		$svg .= '<text x="400" y="480" text-anchor="middle" font-family="system-ui,sans-serif" font-size="22" fill="rgba(255,255,255,.75)">' . htmlspecialchars( $label ) . '</text>';
	}
	$svg .= '</svg>';
	if ( ! is_dir( dirname( $file ) ) ) {
		mkdir( dirname( $file ), 0777, true );
	}
	file_put_contents( $file, $svg );
	return 'file://' . $file;
}

function wpb_placeholders( string $img_dir ): array {
	return array(
		'a' => wpb_placeholder( "$img_dir/sample-a.svg", '#0d6efd', '#6610f2', 'Sample image' ),
		'b' => wpb_placeholder( "$img_dir/sample-b.svg", '#198754', '#0dcaf0', 'Sample image' ),
		'c' => wpb_placeholder( "$img_dir/sample-c.svg", '#fd7e14', '#dc3545', 'Sample image' ),
		'd' => wpb_placeholder( "$img_dir/sample-d.svg", '#1d3557', '#2a9d8f', 'Sample image' ),
	);
}

function wpb_sample_posts( array $ph ): array {
	return array(
		array(
			'id'      => 11,
			'title'   => 'Building a Bootstrap 5 site with WPWiseBones',
			'slug'    => 'building-a-bootstrap-5-site',
			'excerpt' => 'Every template in the WordPress hierarchy is already wired to the Bootstrap 5 grid and components, so you start with content instead of scaffolding.',
			'content' => '<p>Every template in the WordPress hierarchy is already wired to Bootstrap 5.</p>',
			'date'    => 'March 4, 2025',
			'author'  => 'Jane Realtor',
			'thumb'   => $ph['a'],
		),
		array(
			'id'      => 12,
			'title'   => 'Seventeen shortcodes, zero page builders',
			'slug'    => 'seventeen-shortcodes',
			'excerpt' => 'Alerts, cards, accordions, tabs, grids and countdowns render as plain Bootstrap markup you can restyle with utility classes.',
			'content' => '<p>Alerts, cards, accordions, tabs, grids and countdowns.</p>',
			'date'    => 'February 18, 2025',
			'author'  => 'Jane Realtor',
			'thumb'   => $ph['b'],
		),
		array(
			'id'      => 13,
			'title'   => 'Shipping a theme that passes WordPress.org review',
			'slug'    => 'passing-theme-review',
			'excerpt' => 'Escaped output, sanitised Customizer settings and no plugin territory in the theme — the preflight script checks all of it before you zip.',
			'content' => '<p>Escaped output, sanitised settings, no plugin territory.</p>',
			'date'    => 'January 29, 2025',
			'author'  => 'Jane Realtor',
			'thumb'   => $ph['c'],
		),
	);
}

function wpb_boot_theme( string $repo, string $parent, ?string $child = null ): void {
	global $wp_stub;
	$wp_stub['template_dir']   = "$repo/$parent";
	$wp_stub['template_uri']   = "file://$repo/$parent";
	$dir                       = $child ? "$repo/$child" : "$repo/$parent";
	$wp_stub['stylesheet_dir'] = $dir;
	$wp_stub['stylesheet_uri'] = "file://$dir";

	require_once "$repo/$parent/functions.php";
	if ( $child ) {
		require_once "$repo/$child/functions.php";
	}
	do_action( 'after_setup_theme' );
	do_action( 'init' );
	do_action( 'widgets_init' );
}
