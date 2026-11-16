<?php
/**
 * iBuilder one-click site builder.
 *
 * Appearance → iBuilder Setup → Build. Creates the vendor site:
 *   • Home (set as the static front page; front-page.php renders it)
 *   • One page per product, on the iBuilder Product template, carrying the
 *     product key in post meta and the generated copy as its content
 *   • Documentation, Support and About
 *   • Primary and footer menus, assigned to their locations
 *
 * Idempotent. Pages are matched on a meta flag and updated in place rather
 * than matched on title, so renaming a page in the editor does not cause a
 * rebuild to create a duplicate. Menus are rebuilt in place.
 *
 * One honest caveat, stated on the admin screen too: a rebuild overwrites page
 * content with the generated copy. That is the trade for having the copy
 * generated from the listing kits, and it is why the button says Rebuild.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

/** Post meta that marks a page as ours, and which page it is. */
const IBUILDER_SITE_FLAG = '_ibuilder_site_page';

/** Post meta linking a product page to its row in inc/products.php. */
const IBUILDER_SITE_PRODUCT_META = '_ibuilder_site_product';

/* ── Admin screen ─────────────────────────────────────────────────────── */

add_action(
	'admin_menu',
	static function () {
		add_theme_page(
			__( 'iBuilder Setup', 'ibuilder' ),
			__( 'iBuilder Setup', 'ibuilder' ),
			'manage_options',
			'ibuilder-setup',
			'ibuilder_site_render_setup_page'
		);
	}
);

/**
 * Render Appearance → iBuilder Setup.
 */
function ibuilder_site_render_setup_page(): void {
	$built     = (int) get_option( 'ibuilder_site_built', 0 );
	$demo      = ibuilder_site_demo_base();
	$demo_opt  = (string) get_option( 'ibuilder_site_demo_url', '' );
	$locked    = defined( 'IBUILDER_SITE_DEMO_URL' );
	$products  = ibuilder_site_products();
	$with_urls = 0;

	foreach ( $products as $p ) {
		if ( '' !== (string) $p['codester_url'] ) {
			++$with_urls;
		}
	}

	$build_url = wp_nonce_url(
		admin_url( 'admin-post.php?action=ibuilder_site_build' ),
		'ibuilder_site_build'
	);
	?>
	<div class="wrap">
		<h1>
			<?php esc_html_e( 'iBuilder — Site Builder', 'ibuilder' ); ?>
			<span class="title-count" style="vertical-align:middle">
				<?php echo esc_html( 'v' . IBUILDER_SITE_VERSION ); ?>
			</span>
		</h1>

		<p class="description" style="max-width:720px">
			<?php esc_html_e( 'One click builds the vendor site: the front page, a page for each of the eight plugins, and the Documentation, Support and About pages, with the menus wired up. Safe to run more than once — pages are matched on a hidden flag and updated rather than duplicated.', 'ibuilder' ); ?>
		</p>

		<div class="notice notice-warning inline" style="max-width:720px">
			<p>
				<strong><?php esc_html_e( 'A rebuild overwrites page content.', 'ibuilder' ); ?></strong>
				<?php esc_html_e( 'The product copy is generated from the Codester listing kits, so rebuilding replaces whatever is in those pages with the current generated version. Edit the kit and regenerate rather than editing the pages, or stop rebuilding once you start editing by hand.', 'ibuilder' ); ?>
			</p>
		</div>

		<h2 class="title"><?php esc_html_e( 'Status', 'ibuilder' ); ?></h2>
		<table class="widefat striped" style="max-width:720px">
			<tbody>
				<tr>
					<td style="width:220px"><strong><?php esc_html_e( 'Product data', 'ibuilder' ); ?></strong></td>
					<td>
						<?php
						printf(
							/* translators: %d: number of products. */
							esc_html( _n( '%d product loaded from inc/products.php', '%d products loaded from inc/products.php', count( $products ), 'ibuilder' ) ),
							count( $products )
						);
						?>
					</td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Codester links', 'ibuilder' ); ?></strong></td>
					<td>
						<?php if ( $with_urls === count( $products ) ) : ?>
							<?php esc_html_e( 'All eight item URLs are filled in.', 'ibuilder' ); ?>
						<?php else : ?>
							<?php
							printf(
								/* translators: 1: filled count, 2: total. */
								esc_html__( '%1$d of %2$d filled in. The rest point at the seller profile, and their buttons say "See it on Codester" rather than "Buy" — fill codester_url in inc/products.php as listings go live.', 'ibuilder' ),
								(int) $with_urls,
								count( $products )
							);
							?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Demo', 'ibuilder' ); ?></strong></td>
					<td>
						<?php if ( '' !== $demo ) : ?>
							<code><?php echo esc_html( $demo ); ?></code>
							<?php if ( $locked ) : ?>
								<em><?php esc_html_e( '(set by the IBUILDER_SITE_DEMO_URL constant, which wins over this setting)', 'ibuilder' ); ?></em>
							<?php endif; ?>
						<?php else : ?>
							<?php esc_html_e( 'Not set. Every demo button is hidden rather than rendered dead, so the site is perfectly usable without one.', 'ibuilder' ); ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td><strong><?php esc_html_e( 'Last built', 'ibuilder' ); ?></strong></td>
					<td>
						<?php
						if ( $built ) {
							echo esc_html(
								get_date_from_gmt(
									gmdate( 'Y-m-d H:i:s', $built ),
									get_option( 'date_format' ) . ' ' . get_option( 'time_format' )
								)
							);
						} else {
							esc_html_e( 'Never.', 'ibuilder' );
						}
						?>
					</td>
				</tr>
			</tbody>
		</table>

		<h2 class="title"><?php esc_html_e( 'Demo URL', 'ibuilder' ); ?></h2>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ibuilder_site_save_demo">
			<?php wp_nonce_field( 'ibuilder_site_save_demo' ); ?>
			<p>
				<input
					type="url"
					name="ibuilder_site_demo_url"
					class="regular-text code"
					placeholder="https://demo.example.com"
					value="<?php echo esc_attr( $demo_opt ); ?>"
					<?php disabled( $locked ); ?>
				>
				<?php submit_button( __( 'Save', 'ibuilder' ), 'secondary', 'submit', false ); ?>
			</p>
			<p class="description" style="max-width:720px">
				<?php esc_html_e( 'The base URL of the public demo, with no trailing path. Product links are built from it — https://demo.example.com becomes https://demo.example.com/realty/. Leave it empty until the demo is live; anything that is not an http(s) URL is ignored. Setting it does not require a rebuild.', 'ibuilder' ); ?>
			</p>
		</form>

		<h2 class="title"><?php esc_html_e( 'Build', 'ibuilder' ); ?></h2>
		<p>
			<a href="<?php echo esc_url( $build_url ); ?>" class="button button-primary button-hero">
				<?php
				echo $built
					? esc_html__( 'Rebuild the site', 'ibuilder' )
					: esc_html__( 'Build the iBuilder site', 'ibuilder' );
				?>
			</a>
		</p>
	</div>
	<?php
}

/* ── Save the demo URL ───────────────────────────────────────────────────── */

add_action(
	'admin_post_ibuilder_site_save_demo',
	static function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'ibuilder' ) );
		}
		check_admin_referer( 'ibuilder_site_save_demo' );

		$raw = isset( $_POST['ibuilder_site_demo_url'] )
			? sanitize_text_field( wp_unslash( $_POST['ibuilder_site_demo_url'] ) )
			: '';
		$raw = trim( $raw );

		// Store '' rather than a half-valid value: ibuilder_site_demo_base()
		// treats anything that is not http(s) as unset, and an option that
		// looks set but behaves unset is a confusing thing to debug.
		$clean = ( '' !== $raw && preg_match( '#^https?://#i', $raw ) )
			? untrailingslashit( esc_url_raw( $raw ) )
			: '';

		update_option( 'ibuilder_site_demo_url', $clean );

		wp_safe_redirect( admin_url( 'themes.php?page=ibuilder-setup&demo=1' ) );
		exit;
	}
);

/* ── Build ───────────────────────────────────────────────────────────────── */

add_action(
	'admin_post_ibuilder_site_build',
	static function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'ibuilder' ) );
		}
		check_admin_referer( 'ibuilder_site_build' );

		$made = ibuilder_site_run_build();

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'  => 'ibuilder-setup',
					'built' => (int) $made,
				),
				admin_url( 'themes.php' )
			)
		);
		exit;
	}
);

add_action(
	'admin_notices',
	static function () {
		if ( ! isset( $_GET['page'] ) || 'ibuilder-setup' !== $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}

		if ( isset( $_GET['built'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$n = absint( $_GET['built'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			printf(
				'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
				esc_html(
					sprintf(
						/* translators: %d: number of pages. */
						_n( '%d page created or updated.', '%d pages created or updated.', $n, 'ibuilder' ),
						$n
					)
				)
			);
		}

		if ( isset( $_GET['demo'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			printf(
				'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
				esc_html__( 'Demo URL saved.', 'ibuilder' )
			);
		}
	}
);

/**
 * Build or rebuild the whole site.
 *
 * @return int Number of pages created or updated.
 */
function ibuilder_site_run_build(): int {
	// Long copy is only needed here, so it is loaded here rather than on every
	// front-end request.
	$descriptions = array();
	$desc_file    = get_stylesheet_directory() . '/inc/descriptions.php';

	if ( file_exists( $desc_file ) ) {
		require_once $desc_file;
		if ( function_exists( 'ibuilder_site_descriptions' ) ) {
			$descriptions = ibuilder_site_descriptions();
		}
	}

	$ids   = array();
	$count = 0;

	// Home first, so the menus can point at it.
	$home = ibuilder_site_upsert_page(
		'home',
		__( 'Home', 'ibuilder' ),
		'<!-- wp:paragraph --><p>'
			. esc_html__( 'The iBuilder plugin catalogue. This page is rendered by the iBuilder theme; this content is only a fallback shown if the theme is switched away.', 'ibuilder' )
			. '</p><!-- /wp:paragraph -->',
		''
	);

	if ( $home ) {
		$ids['home'] = $home;
		++$count;
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
	}

	// A page per product.
	foreach ( ibuilder_site_products() as $p ) {
		$key  = (string) $p['key'];
		$copy = $descriptions[ $key ] ?? array();

		$id = ibuilder_site_upsert_page(
			$key,
			(string) $p['name'],
			ibuilder_site_product_content( $p, $copy ),
			'page-templates/product.php'
		);

		if ( $id ) {
			update_post_meta( $id, IBUILDER_SITE_PRODUCT_META, $key );
			$ids[ $key ] = $id;
			++$count;
		}
	}

	foreach ( ibuilder_site_static_pages() as $slug => $page ) {
		$id = ibuilder_site_upsert_page( $slug, $page['title'], $page['content'], '' );
		if ( $id ) {
			$ids[ $slug ] = $id;
			++$count;
		}
	}

	ibuilder_site_build_menus( $ids );

	update_option( 'ibuilder_site_built', time() );

	return $count;
}

/**
 * Body copy for a product page.
 *
 * @param array<string, mixed>  $p    Product row.
 * @param array<string, string> $copy Generated description / requirements.
 * @return string
 */
function ibuilder_site_product_content( array $p, array $copy ): string {
	$html = '';

	if ( ! empty( $copy['description'] ) ) {
		$html .= $copy['description'];
	} else {
		// No generated copy: say so rather than shipping an empty page.
		$html .= '<p>' . esc_html( (string) $p['tagline'] ) . '</p>';
	}

	if ( ! empty( $copy['requirements'] ) ) {
		$html .= '<h2>' . esc_html__( 'Requirements', 'ibuilder' ) . '</h2>';
		$html .= $copy['requirements'];
	}

	// Wrapped once so the block editor treats it as a single HTML block rather
	// than trying to parse eight sections into blocks it did not create.
	return '<!-- wp:html -->' . $html . '<!-- /wp:html -->';
}

/**
 * The non-product pages.
 *
 * @return array<string, array{title: string, content: string}>
 */
function ibuilder_site_static_pages(): array {
	$profile = IBUILDER_SITE_PROFILE_URL;

	$docs  = '<!-- wp:html -->';
	$docs .= '<p class="lead">' . esc_html__( 'Every plugin ships its full documentation inside the zip, under documentation/, alongside a readme.txt. Nothing here depends on a wiki that might not be around next year.', 'ibuilder' ) . '</p>';
	$docs .= '<h2>' . esc_html__( 'Where to look first', 'ibuilder' ) . '</h2><ul>';
	$docs .= '<li>' . esc_html__( 'readme.txt — what the plugin does, what it requires, and an "External services" section naming every host it can contact.', 'ibuilder' ) . '</li>';
	$docs .= '<li>' . esc_html__( 'documentation/ — the full guide, including setup and the hooks available to developers.', 'ibuilder' ) . '</li>';
	$docs .= '<li>' . esc_html__( 'LICENSE.txt — GPL v2 or later, plus the licence of anything bundled.', 'ibuilder' ) . '</li>';
	$docs .= '</ul>';
	$docs .= '<h2>' . esc_html__( 'Overriding templates', 'ibuilder' ) . '</h2>';
	$docs .= '<p>' . esc_html__( 'Where a plugin renders front-end markup, every template can be overridden from your theme: copy the file into a folder named after the plugin in your theme directory and the plugin will use yours instead. The markup is yours to own.', 'ibuilder' ) . '</p>';
	$docs .= '<h2>' . esc_html__( 'The plugins', 'ibuilder' ) . '</h2><ul>';

	foreach ( ibuilder_site_products() as $p ) {
		$docs .= '<li><strong>' . esc_html( (string) $p['name'] ) . '</strong> — ' . esc_html( (string) $p['tagline'] ) . '</li>';
	}

	$docs .= '</ul><!-- /wp:html -->';

	$support  = '<!-- wp:html -->';
	$support .= '<p class="lead">' . esc_html__( 'Support comes from the person who wrote the code.', 'ibuilder' ) . '</p>';
	$support .= '<h2>' . esc_html__( 'Before you write in', 'ibuilder' ) . '</h2><ul>';
	$support .= '<li>' . esc_html__( 'Check the readme\'s requirements — the PHP and WordPress versions, and whether the plugin needs WooCommerce.', 'ibuilder' ) . '</li>';
	$support .= '<li>' . esc_html__( 'Try it with other plugins deactivated and a default theme, which separates a bug from a conflict.', 'ibuilder' ) . '</li>';
	$support .= '<li>' . esc_html__( 'Have the exact error text ready, and what you did immediately before it.', 'ibuilder' ) . '</li>';
	$support .= '</ul>';
	$support .= '<h2>' . esc_html__( 'What is in scope', 'ibuilder' ) . '</h2>';
	$support .= '<p>' . esc_html__( 'The plugin not doing what its description says it does. That gets fixed. Questions about how to use it get answered. Custom development, and making the plugin do something it was never described as doing, are a separate conversation rather than a support ticket.', 'ibuilder' ) . '</p>';
	$support .= '<h2>' . esc_html__( 'Where to ask', 'ibuilder' ) . '</h2>';
	$support .= '<p>' . sprintf(
		/* translators: %s: Codester profile URL. */
		wp_kses_post( __( 'Through the comments on the item\'s <a href="%s" rel="noopener">Codester listing</a>, which keeps the question attached to the purchase. Replace this paragraph with your own contact route if you would rather take support by email.', 'ibuilder' ) ),
		esc_url( $profile )
	) . '</p>';
	$support .= '<!-- /wp:html -->';

	$about  = '<!-- wp:html -->';
	$about .= '<p class="lead">' . esc_html__( 'iBuilder builds WordPress plugins for property, construction and the back office — the kind of software where the data matters and the licence check does not.', 'ibuilder' ) . '</p>';
	$about .= '<h2>' . esc_html__( 'How these are built', 'ibuilder' ) . '</h2><ul>';
	$about .= '<li>' . esc_html__( 'No licence key, no activation, no domain lock, no phone-home. There is no server of ours in the loop, which means there is no server of ours to go down.', 'ibuilder' ) . '</li>';
	$about .= '<li>' . esc_html__( 'Readable, editable PHP. Nothing encrypted, nothing obfuscated, nothing minified beyond the JavaScript bundles — whose unminified source ships too.', 'ibuilder' ) . '</li>';
	$about .= '<li>' . esc_html__( 'Their own database tables where the data warrants it, rather than bending wp_posts until it stops being fast.', 'ibuilder' ) . '</li>';
	$about .= '<li>' . esc_html__( 'A clean uninstall: delete the plugin and it takes its tables, options and scheduled events with it.', 'ibuilder' ) . '</li>';
	$about .= '<li>' . esc_html__( 'Every external service named in the readme, optional, and keyed with your own credentials.', 'ibuilder' ) . '</li>';
	$about .= '</ul>';
	$about .= '<h2>' . esc_html__( 'Where to buy', 'ibuilder' ) . '</h2>';
	$about .= '<p>' . sprintf(
		/* translators: %s: Codester profile URL. */
		wp_kses_post( __( 'Everything is sold through <a href="%s" rel="noopener">Codester</a>, which handles payment and delivery. This site does not take payment and never asks for a card.', 'ibuilder' ) ),
		esc_url( $profile )
	) . '</p>';
	$about .= '<!-- /wp:html -->';

	return array(
		'docs'    => array(
			'title'   => __( 'Documentation', 'ibuilder' ),
			'content' => $docs,
		),
		'support' => array(
			'title'   => __( 'Support', 'ibuilder' ),
			'content' => $support,
		),
		'about'   => array(
			'title'   => __( 'About', 'ibuilder' ),
			'content' => $about,
		),
	);
}

/**
 * Create or update a page identified by our meta flag.
 *
 * Matched on the flag rather than the slug or title, so renaming a page in the
 * editor does not make the next rebuild create a second copy of it.
 *
 * @param string $slug     Flag value and desired post_name.
 * @param string $title    Page title.
 * @param string $content  Page content.
 * @param string $template Page template path, or '' for the default.
 * @return int Page ID, or 0 on failure.
 */
function ibuilder_site_upsert_page( string $slug, string $title, string $content, string $template ): int {
	$existing = get_posts(
		array(
			'post_type'        => 'page',
			'post_status'      => 'any',
			'meta_key'         => IBUILDER_SITE_FLAG, // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'       => $slug,              // phpcs:ignore WordPress.DB.SlowDBQuery
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'suppress_filters' => false,
		)
	);

	$postarr = array(
		'post_title'   => $title,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
	);

	if ( $existing ) {
		$postarr['ID'] = (int) $existing[0];
		$id            = wp_update_post( $postarr, true );
	} else {
		// Only set post_name on creation. Forcing it on update would undo a
		// deliberate slug change, and the permalink may already be linked to.
		$postarr['post_name'] = $slug;
		$id                   = wp_insert_post( $postarr, true );

		if ( ! is_wp_error( $id ) && $id ) {
			update_post_meta( (int) $id, IBUILDER_SITE_FLAG, $slug );
		}
	}

	if ( is_wp_error( $id ) || ! $id ) {
		return 0;
	}

	$id = (int) $id;

	if ( '' !== $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}

	return $id;
}

/* ── Menus ───────────────────────────────────────────────────────────────── */

/**
 * Build the primary and footer menus.
 *
 * @param array<string, int> $ids Page IDs keyed by slug.
 */
function ibuilder_site_build_menus( array $ids ): void {
	$primary = array();

	if ( ! empty( $ids['home'] ) ) {
		$primary[] = array( 'page', (int) $ids['home'], __( 'Home', 'ibuilder' ) );
	}

	// The eight products as children of a "Plugins" parent, so the bar does
	// not become eleven top-level items.
	$children = array();
	foreach ( ibuilder_site_products() as $p ) {
		$key = (string) $p['key'];
		if ( ! empty( $ids[ $key ] ) ) {
			$children[] = array( 'page', (int) $ids[ $key ], (string) $p['label'] );
		}
	}

	if ( $children ) {
		$primary[] = array( 'url', home_url( '/#products' ), __( 'Plugins', 'ibuilder' ), $children );
	}

	foreach ( array(
		'docs'    => __( 'Docs', 'ibuilder' ),
		'support' => __( 'Support', 'ibuilder' ),
		'about'   => __( 'About', 'ibuilder' ),
	) as $slug => $label ) {
		if ( ! empty( $ids[ $slug ] ) ) {
			$primary[] = array( 'page', (int) $ids[ $slug ], $label );
		}
	}

	$demo = ibuilder_site_demo_base();
	if ( '' !== $demo ) {
		$primary[] = array( 'url', $demo, __( 'Live demo', 'ibuilder' ) );
	}

	$footer = array(
		array( 'url', IBUILDER_SITE_PROFILE_URL, __( 'Codester', 'ibuilder' ) ),
	);

	foreach ( array( 'docs', 'support', 'about' ) as $slug ) {
		if ( ! empty( $ids[ $slug ] ) ) {
			array_unshift( $footer, array( 'page', (int) $ids[ $slug ], get_the_title( (int) $ids[ $slug ] ) ) );
		}
	}

	ibuilder_site_rebuild_menu( __( 'iBuilder Primary', 'ibuilder' ), 'primary', $primary );
	ibuilder_site_rebuild_menu( __( 'iBuilder Footer', 'ibuilder' ), 'footer', $footer );
}

/**
 * Wipe and rebuild a named menu, then assign it to a theme location.
 *
 * @param string                                                   $name     Menu name.
 * @param string                                                   $location Theme location.
 * @param array<int, array{0:string,1:int|string,2:string,3?:array}> $items   Items, each optionally with children.
 */
function ibuilder_site_rebuild_menu( string $name, string $location, array $items ): void {
	$menu = wp_get_nav_menu_object( $name );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return;
		}
		$menu_id = (int) $menu_id;
	} else {
		$menu_id = (int) $menu->term_id;
		foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}

	foreach ( $items as $item ) {
		$parent_id = ibuilder_site_add_menu_item( $menu_id, 0, $item[0], $item[1], $item[2] );

		if ( ! empty( $item[3] ) && $parent_id ) {
			foreach ( $item[3] as $child ) {
				ibuilder_site_add_menu_item( $menu_id, $parent_id, $child[0], $child[1], $child[2] );
			}
		}
	}

	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Add one item to a menu.
 *
 * @param int        $menu_id Menu term ID.
 * @param int        $parent  Parent menu-item ID, or 0.
 * @param string     $type    'page' or 'url'.
 * @param int|string $target  Page ID or URL.
 * @param string     $label   Item label.
 * @return int Menu item ID, or 0 on failure.
 */
function ibuilder_site_add_menu_item( int $menu_id, int $parent, string $type, $target, string $label ): int {
	$args = array(
		'menu-item-title'     => $label,
		'menu-item-status'    => 'publish',
		'menu-item-parent-id' => $parent,
	);

	if ( 'page' === $type ) {
		$args['menu-item-object']    = 'page';
		$args['menu-item-object-id'] = (int) $target;
		$args['menu-item-type']      = 'post_type';
	} else {
		$args['menu-item-url']  = (string) $target;
		$args['menu-item-type'] = 'custom';
	}

	$id = wp_update_nav_menu_item( $menu_id, 0, $args );

	return is_wp_error( $id ) ? 0 : (int) $id;
}
