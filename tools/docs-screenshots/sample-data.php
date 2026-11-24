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
	if ( $child && file_exists( "$repo/$child/functions.php" ) ) {
		require_once "$repo/$child/functions.php";
	}
	do_action( 'after_setup_theme' );
	do_action( 'init' );
	do_action( 'widgets_init' );
}

/**
 * A fictional business, and three on-topic blog posts, for each library theme.
 */
function wpb_library_sample( string $theme, array $ph ): array {
	$biz = array(
		'wisebones-residential'         => array( 'Evergreen Realty Group', 'Local agents, real results', array( 'Spring market update: what buyers should know', 'Five upgrades that pay off at resale', 'A first-time buyer\'s guide to closing costs' ) ),
		'wisebones-commercial'          => array( 'Harborline Commercial', 'Office, industrial, retail and multifamily advisory', array( 'Q2 industrial vacancy report', 'Sale-leaseback: when it makes sense', 'Reading a cap rate the right way' ) ),
		'wisebones-property-management' => array( 'Keystone Property Management', 'Full-service residential management', array( 'Preparing your rental for winter', 'How we screen applicants fairly', 'Owner FAQ: reserves and repairs' ) ),
		'wisebones-mortgage'            => array( 'Brightpath Home Loans', 'Mortgages explained in plain language', array( 'Fixed or adjustable: choosing a rate type', 'What lenders look for in a pre-approval', 'Down-payment assistance programs, explained' ) ),
		'wisebones-title-escrow'        => array( 'Cornerstone Title & Escrow', 'Title insurance and settlement services', array( 'Wire fraud: how to protect your closing', 'What an owner\'s title policy covers', 'Timeline of a typical escrow' ) ),
		'wisebones-home-builder'        => array( 'Ridgeway Homes', 'New homes, built around how you live', array( 'Inside the design studio', 'Building on your lot: the first 90 days', 'Energy-efficient features in every Ridgeway home' ) ),
		'wisebones-general-contractor'  => array( 'Ironline Builders', 'General contracting and construction management', array( 'Topping out at the Riverside medical office', 'Why preconstruction saves money', 'Our 2025 safety record' ) ),
		'wisebones-remodeling'          => array( 'Hearthstone Remodeling', 'Design-build kitchens, baths and additions', array( 'Kitchen remodel budget guide', 'Planning an addition: permits and timing', 'Bathroom trends worth the investment' ) ),
		'wisebones-trades'              => array( 'Summit Roofing Co.', 'Licensed roofing contractor — 24/7 emergency repairs', array( 'Storm damage? What to do first', 'Asphalt vs. metal roofing', 'Signs your roof needs replacing' ) ),
		'wisebones-architecture'        => array( 'Atelier North', 'Architecture and interiors', array( 'Library renovation wins regional award', 'Designing for daylight', 'Adaptive reuse in the old mill district' ) ),
		'wisebones-landscaping'         => array( 'Greenway Outdoor Living', 'Landscape design, build and care', array( 'Spring cleanup checklist', 'Choosing pavers for your patio', 'Drought-tolerant planting ideas' ) ),
		'wisebones-interiors'           => array( 'Maison Rose Interiors', 'Interior design and home staging', array( 'Staging tips that sell faster', 'Layering texture in a neutral room', 'How a design consultation works' ) ),
	);
	$row   = isset( $biz[ $theme ] ) ? $biz[ $theme ] : array( 'WiseBones', 'Industry theme', array( 'Post one', 'Post two', 'Post three' ) );
	$posts = wpb_sample_posts( $ph );
	foreach ( $posts as $i => &$post ) {
		$post['title']   = $row[2][ $i ];
		$post['excerpt'] = 'Placeholder post for the theme screenshot.';
		$post['author']  = 'Sample author';
	}
	unset( $post );
	return array(
		'name'    => $row[0],
		'tagline' => $row[1],
		'posts'   => $posts,
	);
}
