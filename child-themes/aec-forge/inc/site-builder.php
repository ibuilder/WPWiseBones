<?php
/**
 * AEC Forge one-click promo-site builder.
 *
 * Appearance → AEC Forge Setup → Build. Creates the marketplace promo site:
 *   • Pages: Home (static front page), How It Works, The Concept
 *   • Primary + footer nav menus, assigned to their locations, linking the
 *     AEC Market plugin pages (Become a Vendor, Vendor Dashboard) and the
 *     WooCommerce shop when those plugins are active
 *
 * Idempotent: pages are matched by a meta flag and updated in place; menus are
 * rebuilt in place. Safe to run more than once.
 */

defined( 'ABSPATH' ) || exit;

const AEC_FORGE_FLAG = '_aec_forge_page_slug';

/* ── Admin page ───────────────────────────────────────────────────────── */

add_action( 'admin_menu', function () {
	add_theme_page(
		__( 'AEC Forge Setup', 'aec-forge' ),
		__( 'AEC Forge Setup', 'aec-forge' ),
		'manage_options',
		'aec-forge-setup',
		'aec_forge_render_setup_page'
	);
} );

function aec_forge_render_setup_page() {
	$done    = get_option( 'aec_forge_site_built' );
	$market  = class_exists( 'AEC_Market' );
	$woo     = class_exists( 'WooCommerce' );
	$run_url = wp_nonce_url( admin_url( 'admin-post.php?action=aec_forge_build_site' ), 'aec_forge_build_site' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'AEC Forge — Site Builder', 'aec-forge' ); ?>
			<span class="title-count" style="vertical-align:middle"><?php echo esc_html( 'v' . ( defined( 'AEC_FORGE_VERSION' ) ? AEC_FORGE_VERSION : '' ) ); ?></span>
		</h1>
		<p class="description" style="max-width:680px">
			<?php esc_html_e( 'One click builds the marketplace promo site: the Home, How It Works and The Concept pages, the static front page, and menus wired to the marketplace (shop, vendor signup, vendor dashboard). Safe to run more than once — existing content is updated, not duplicated.', 'aec-forge' ); ?>
		</p>

		<h2 class="title"><?php esc_html_e( 'Prerequisites', 'aec-forge' ); ?></h2>
		<ul style="list-style:disc;margin-left:20px">
			<li><?php echo $woo
				? '✅ ' . esc_html__( 'WooCommerce active — the Marketplace menu item will link to the shop.', 'aec-forge' )
				: '⚠️ ' . esc_html__( 'WooCommerce is NOT active — install it first so the marketplace catalog exists.', 'aec-forge' ); ?></li>
			<li><?php echo $market
				? '✅ ' . esc_html__( 'AEC Market plugin active — vendor signup and dashboard links will resolve to its pages.', 'aec-forge' )
				: '⚠️ ' . esc_html__( 'AEC Market plugin is NOT active — menus fall back to placeholder URLs until you activate it and rebuild.', 'aec-forge' ); ?></li>
		</ul>

		<?php if ( $done ) : ?>
			<div class="notice notice-success inline"><p>
				<?php
				printf(
					/* translators: %s is a date/time. */
					esc_html__( 'The site was last built on %s. Running again refreshes it in place.', 'aec-forge' ),
					esc_html( get_date_from_gmt( gmdate( 'Y-m-d H:i:s', (int) $done ), get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) )
				);
				?>
			</p></div>
		<?php endif; ?>

		<p style="margin-top:1.5rem">
			<a href="<?php echo esc_url( $run_url ); ?>" class="button button-primary button-hero">
				<?php echo $done ? esc_html__( 'Rebuild / Refresh Site', 'aec-forge' ) : esc_html__( 'Build the AEC Forge Site', 'aec-forge' ); ?>
			</a>
		</p>
	</div>
	<?php
}

/* ── Build handler ────────────────────────────────────────────────────── */

add_action( 'admin_post_aec_forge_build_site', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'aec-forge' ) );
	}
	check_admin_referer( 'aec_forge_build_site' );

	aec_forge_run_site_build();

	wp_safe_redirect( admin_url( 'themes.php?page=aec-forge-setup&built=1' ) );
	exit;
} );

/** Run the full build. */
function aec_forge_run_site_build(): void {
	$ids = [];
	foreach ( aec_forge_site_pages() as $slug => $page ) {
		$ids[ $slug ] = aec_forge_upsert_page( $slug, $page['title'], $page['content'] );
	}

	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $ids['home'] );
	}

	aec_forge_build_menus( $ids );

	update_option( 'aec_forge_site_built', time() );
}

/* ── Pages ────────────────────────────────────────────────────────────── */

/** @return array<string, array{title: string, content: string}> */
function aec_forge_site_pages(): array {
	return [
		'home'         => [
			'title'   => __( 'Home', 'aec-forge' ),
			// front-page.php renders the homepage; this content is a fallback
			// shown only if the theme is switched away.
			'content' => '<!-- wp:paragraph --><p>' . esc_html__( 'AEC Forge — the marketplace where AEC builders sell licensed tools and tiered services. This page is rendered by the AEC Forge theme.', 'aec-forge' ) . '</p><!-- /wp:paragraph -->',
		],
		'how-it-works' => [
			'title'   => __( 'How It Works', 'aec-forge' ),
			'content' => aec_forge_page_how_it_works(),
		],
		'the-concept'  => [
			'title'   => __( 'The Concept', 'aec-forge' ),
			'content' => aec_forge_page_concept(),
		],
	];
}

function aec_forge_page_how_it_works(): string {
	$register  = aec_forge_market_url( 'vendor_register_page', '/become-a-vendor/' );
	$dashboard = aec_forge_market_url( 'vendor_dashboard_page', '/vendor-dashboard/' );
	$shop      = aec_forge_shop_url();

	$html  = '<!-- wp:html --><div class="af-section" style="padding-top:1rem">';
	$html .= '<h2>' . esc_html__( 'For builders (vendors)', 'aec-forge' ) . '</h2><ol>';
	$html .= '<li><strong>' . esc_html__( 'Apply.', 'aec-forge' ) . '</strong> ' . sprintf( /* translators: %s: URL */ wp_kses_post( __( 'Fill in the <a href="%s">vendor application</a> with your store name and what you build. Applications are reviewed by the marketplace team.', 'aec-forge' ) ), esc_url( $register ) ) . '</li>';
	$html .= '<li><strong>' . esc_html__( 'List.', 'aec-forge' ) . '</strong> ' . sprintf( /* translators: %s: URL */ wp_kses_post( __( 'From your <a href="%s">dashboard</a>, publish a Program (a downloadable script, add-in or template — with license keys and activation limits) or a Service (Basic / Standard / Premium packages with delivery times).', 'aec-forge' ) ), esc_url( $dashboard ) ) . '</li>';
	$html .= '<li><strong>' . esc_html__( 'Sell & get paid.', 'aec-forge' ) . '</strong> ' . esc_html__( 'Each completed order records your earning after the platform commission. Track pending and paid amounts in the Earnings tab; payouts go to the PayPal or Stripe details in your store settings.', 'aec-forge' ) . '</li></ol>';
	$html .= '<h2>' . esc_html__( 'For buyers', 'aec-forge' ) . '</h2><ol>';
	$html .= '<li><strong>' . esc_html__( 'Browse.', 'aec-forge' ) . '</strong> ' . sprintf( /* translators: %s: URL */ wp_kses_post( __( 'Explore the <a href="%s">marketplace</a> — filter Programs & Scripts or Services, and view each vendor\'s public store.', 'aec-forge' ) ), esc_url( $shop ) ) . '</li>';
	$html .= '<li><strong>' . esc_html__( 'Buy once.', 'aec-forge' ) . '</strong> ' . esc_html__( 'Add a Revit add-in and an IFC-cleanup package to the same cart. Downloads deliver instantly with license keys shown on your order page.', 'aec-forge' ) . '</li>';
	$html .= '<li><strong>' . esc_html__( 'Activate.', 'aec-forge' ) . '</strong> ' . esc_html__( 'Licensed tools validate themselves against the AEC Forge license API — your keys, your activation counts, visible on every order.', 'aec-forge' ) . '</li></ol>';
	$html .= '</div><!-- /wp:html -->';

	return $html;
}

function aec_forge_page_concept(): string {
	$html  = '<!-- wp:html --><div class="af-section" style="padding-top:1rem">';
	$html .= '<p class="lead">' . esc_html__( 'The AEC industry runs on tools its own people build — Dynamo graphs, Revit add-ins, Excel estimating models, IFC pipelines, AI assistants. Almost none of them ever reach the colleagues who need them.', 'aec-forge' ) . '</p>';
	$html .= '<h2>' . esc_html__( 'The gap', 'aec-forge' ) . '</h2>';
	$html .= '<p>' . esc_html__( 'Generic marketplaces treat a Revit add-in like a website template, and freelance platforms treat a BIM specialist like a logo designer. Neither understands licensing per seat, model auditing scopes, or the fact that the best person to support a tool is the builder who wrote it.', 'aec-forge' ) . '</p>';
	$html .= '<h2>' . esc_html__( 'The bet', 'aec-forge' ) . '</h2>';
	$html .= '<p>' . esc_html__( 'AEC Forge puts the product and the person on the same shelf: buy the script, or hire its author to adapt it. Licensed downloads with a real activation API, tiered service packages with honest delivery times, vetted vendors, and a flat transparent commission — on an open-source, GPL platform.', 'aec-forge' ) . '</p>';
	$html .= '<h2>' . esc_html__( 'Built in the open', 'aec-forge' ) . '</h2>';
	$html .= '<p>' . wp_kses_post( __( 'The marketplace engine is the free <a href="https://github.com/ibuilder/aec-market">AEC Market plugin</a> for WooCommerce — the code that runs this site is the code you can read, extend and self-host.', 'aec-forge' ) ) . '</p>';
	$html .= '</div><!-- /wp:html -->';

	return $html;
}

/** Create-or-update a page identified by the AEC Forge meta flag. */
function aec_forge_upsert_page( string $slug, string $title, string $content ): int {
	$existing = get_posts( [
		'post_type'      => 'page',
		'post_status'    => 'any',
		'meta_key'       => AEC_FORGE_FLAG, // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value'     => $slug,          // phpcs:ignore WordPress.DB.SlowDBQuery
		'posts_per_page' => 1,
		'fields'         => 'ids',
	] );

	$postarr = [
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	];

	if ( $existing ) {
		$postarr['ID'] = (int) $existing[0];
		$id            = wp_update_post( $postarr );
	} else {
		$id = wp_insert_post( $postarr );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, AEC_FORGE_FLAG, $slug );
		}
	}

	return is_wp_error( $id ) ? 0 : (int) $id;
}

/* ── Menus ────────────────────────────────────────────────────────────── */

function aec_forge_build_menus( array $ids ): void {
	$shop      = aec_forge_shop_url();
	$register  = aec_forge_market_url( 'vendor_register_page', '/become-a-vendor/' );
	$dashboard = aec_forge_market_url( 'vendor_dashboard_page', '/vendor-dashboard/' );

	$primary = [];
	if ( ! empty( $ids['home'] ) ) {
		$primary[] = [ 'page', (int) $ids['home'], __( 'Home', 'aec-forge' ) ];
	}
	$primary[] = [ 'url', $shop, __( 'Marketplace', 'aec-forge' ) ];
	if ( ! empty( $ids['how-it-works'] ) ) {
		$primary[] = [ 'page', (int) $ids['how-it-works'], __( 'How It Works', 'aec-forge' ) ];
	}
	if ( ! empty( $ids['the-concept'] ) ) {
		$primary[] = [ 'page', (int) $ids['the-concept'], __( 'The Concept', 'aec-forge' ) ];
	}
	$primary[] = [ 'url', $register, __( 'Become a Vendor', 'aec-forge' ) ];
	$primary[] = [ 'url', $dashboard, __( 'Vendor Dashboard', 'aec-forge' ) ];

	$footer = [
		[ 'url', $register, __( 'Become a Vendor', 'aec-forge' ) ],
		[ 'url', 'https://github.com/ibuilder/aec-market', __( 'GitHub', 'aec-forge' ) ],
		[ 'url', 'https://ibuilder.github.io/aec-market/', __( 'Plugin Docs', 'aec-forge' ) ],
	];
	if ( ! empty( $ids['the-concept'] ) ) {
		array_unshift( $footer, [ 'page', (int) $ids['the-concept'], __( 'The Concept', 'aec-forge' ) ] );
	}

	aec_forge_rebuild_menu( __( 'AEC Forge Primary', 'aec-forge' ), 'primary', $primary );
	aec_forge_rebuild_menu( __( 'AEC Forge Footer', 'aec-forge' ), 'footer', $footer );
}

/**
 * Wipe-and-rebuild a named menu, then assign it to a theme location.
 *
 * @param array $items List of [type ('page'|'url'), page-ID-or-URL, label].
 */
function aec_forge_rebuild_menu( string $name, string $location, array $items ): void {
	$menu = wp_get_nav_menu_object( $name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return;
		}
	} else {
		$menu_id = (int) $menu->term_id;
		foreach ( wp_get_nav_menu_items( $menu_id ) ?: [] as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}

	foreach ( $items as $item ) {
		[ $type, $target, $label ] = $item;

		if ( 'page' === $type ) {
			wp_update_nav_menu_item( $menu_id, 0, [
				'menu-item-title'     => $label,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => (int) $target,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			] );
		} else {
			wp_update_nav_menu_item( $menu_id, 0, [
				'menu-item-title'  => $label,
				'menu-item-url'    => $target,
				'menu-item-type'   => 'custom',
				'menu-item-status' => 'publish',
			] );
		}
	}

	$locations              = get_theme_mod( 'nav_menu_locations', [] );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
