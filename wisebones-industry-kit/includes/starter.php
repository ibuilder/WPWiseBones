<?php
/**
 * One-click starter site: Appearance → Starter Site.
 *
 * Reads the `starter` block of the active WPWiseBones industry theme's config
 * and creates its pages, main menu, service-area terms and Service entries,
 * then sets the static front page. Pages whose slug already exists are left
 * alone, so running it on a live site never overwrites content.
 *
 * Sample listings, projects and testimonials are optional and are created as
 * drafts: they show the owner the shape of an entry without ever appearing on
 * the public site until someone has edited and published them.
 *
 * Everything created is logged, and "Remove starter content" deletes exactly
 * that — and only entries still untouched since import.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * The active theme's industry config, or an empty array.
 */
function wbik_theme_config(): array {
	return function_exists( 'wpwisebones_industry_config' ) ? (array) wpwisebones_industry_config() : array();
}

/**
 * The starter definition, with service and area lists taken from the front
 * page sections when the starter block does not list its own.
 */
function wbik_starter_plan(): array {
	$config  = wbik_theme_config();
	$starter = isset( $config['starter'] ) ? (array) $config['starter'] : array();
	if ( ! $starter ) {
		return array();
	}
	$sections = isset( $config['sections'] ) ? (array) $config['sections'] : array();
	$starter  = wp_parse_args(
		$starter,
		array(
			'pages'    => array(),
			'front'    => 'home',
			'blog'     => '',
			'menu'     => array(),
			'services' => isset( $sections['services']['items'] ) ? (array) $sections['services']['items'] : array(),
			'areas'    => isset( $sections['areas']['items'] ) ? (array) $sections['areas']['items'] : array(),
			'terms'    => array(),
			'samples'  => array(),
		)
	);
	if ( empty( $starter['samples'] ) ) {
		$type = isset( $sections['featured']['type'] ) ? (string) $sections['featured']['type'] : '';
		if ( $type && ! empty( $sections['featured']['samples'] ) ) {
			$starter['samples'][ $type ] = (array) $sections['featured']['samples'];
		}
		if ( ! empty( $sections['testimonials']['samples'] ) ) {
			$starter['samples']['testimonial'] = (array) $sections['testimonials']['samples'];
		}
	}
	return $starter;
}

add_action( 'admin_menu', 'wbik_starter_menu' );

/**
 * Appearance → Starter Site.
 */
function wbik_starter_menu() {
	add_theme_page( __( 'Starter Site', 'wisebones-industry-kit' ), __( 'Starter Site', 'wisebones-industry-kit' ), 'edit_theme_options', 'wbik-starter', 'wbik_starter_page' );
}

/**
 * The admin screen.
 */
function wbik_starter_page() {
	$plan   = wbik_starter_plan();
	$log    = get_option( 'wbik_starter_log', array() );
	$config = wbik_theme_config();
	$notice = isset( $_GET['wbik_done'] ) ? sanitize_key( wp_unslash( $_GET['wbik_done'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display-only flag from our own redirect.
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Starter Site', 'wisebones-industry-kit' ); ?></h1>
		<?php if ( 'built' === $notice ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Starter site created. Your front page, menu and pages are ready to edit.', 'wisebones-industry-kit' ); ?></p></div>
		<?php elseif ( 'removed' === $notice ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Starter content removed.', 'wisebones-industry-kit' ); ?></p></div>
		<?php endif; ?>

		<?php if ( ! $plan ) : ?>
			<p><?php esc_html_e( 'The active theme does not define a starter site. Activate one of the WPWiseBones industry child themes to use this screen.', 'wisebones-industry-kit' ); ?></p>
		<?php else : ?>
			<p>
				<?php
				/* translators: %s: theme vertical name, e.g. "General Contractor". */
				echo esc_html( sprintf( __( 'Builds the %s starter site from the active theme. Pages that already exist (matched by slug) are skipped, never overwritten.', 'wisebones-industry-kit' ), isset( $config['label'] ) ? $config['label'] : wp_get_theme()->get( 'Name' ) ) );
				?>
			</p>
			<ul class="ul-disc">
				<?php /* translators: %s: comma-separated page titles. */ ?>
				<li><?php echo esc_html( sprintf( __( 'Pages: %s', 'wisebones-industry-kit' ), implode( ', ', wp_list_pluck( array_values( (array) $plan['pages'] ), 'title' ) ) ) ); ?></li>
				<li><?php esc_html_e( 'A main menu in the primary location', 'wisebones-industry-kit' ); ?></li>
				<?php if ( $plan['services'] && wbik_type_enabled( 'service' ) ) : ?>
					<?php /* translators: %d: number of services. */ ?>
					<li><?php echo esc_html( sprintf( _n( '%d service entry', '%d service entries', count( $plan['services'] ), 'wisebones-industry-kit' ), count( $plan['services'] ) ) ); ?></li>
				<?php endif; ?>
				<?php if ( $plan['areas'] && taxonomy_exists( 'wbik_area' ) ) : ?>
					<?php /* translators: %d: number of areas. */ ?>
					<li><?php echo esc_html( sprintf( _n( '%d service area', '%d service areas', count( $plan['areas'] ), 'wisebones-industry-kit' ), count( $plan['areas'] ) ) ); ?></li>
				<?php endif; ?>
				<li><?php esc_html_e( 'Sets the static front page', 'wisebones-industry-kit' ); ?></li>
			</ul>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="wbik_starter_build">
				<?php wp_nonce_field( 'wbik_starter_build' ); ?>
				<p><label><input type="checkbox" name="samples" value="1"> <?php esc_html_e( 'Also add sample listings / projects and testimonials as drafts, to edit and publish yourself', 'wisebones-industry-kit' ); ?></label></p>
				<?php submit_button( __( 'Build starter site', 'wisebones-industry-kit' ), 'primary', 'submit', false ); ?>
			</form>
		<?php endif; ?>

		<?php if ( ! empty( $log['posts'] ) || ! empty( $log['terms'] ) || ! empty( $log['menu'] ) ) : ?>
			<hr>
			<h2><?php esc_html_e( 'Remove starter content', 'wisebones-industry-kit' ); ?></h2>
			<p><?php esc_html_e( 'Deletes the pages, entries, terms and menu this screen created — except any you have edited since — and restores your previous front-page setting.', 'wisebones-industry-kit' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="wbik_starter_remove">
				<?php wp_nonce_field( 'wbik_starter_remove' ); ?>
				<?php submit_button( __( 'Remove starter content', 'wisebones-industry-kit' ), 'delete', 'submit', false ); ?>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Resolve a starter menu target to a nav-menu item definition.
 *
 * @param string $target '/', 'page:slug', 'archive:type' or a URL.
 * @param array  $pages  Page slug => ID.
 * @return array|null
 */
function wbik_starter_menu_item( string $target, array $pages ) {
	if ( 0 === strpos( $target, 'page:' ) ) {
		$slug = substr( $target, 5 );
		if ( empty( $pages[ $slug ] ) ) {
			return null;
		}
		return array(
			'menu-item-object-id' => $pages[ $slug ],
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
		);
	}
	if ( 0 === strpos( $target, 'archive:' ) ) {
		$type = 'wbik_' . sanitize_key( substr( $target, 8 ) );
		if ( ! post_type_exists( $type ) ) {
			return null;
		}
		return array(
			'menu-item-object' => $type,
			'menu-item-type'   => 'post_type_archive',
		);
	}
	return array(
		'menu-item-url'  => '/' === $target ? home_url( '/' ) : ( preg_match( '#^https?://#', $target ) ? $target : home_url( $target ) ),
		'menu-item-type' => 'custom',
	);
}

add_action( 'admin_post_wbik_starter_build', 'wbik_starter_build' );

/**
 * Build the starter site.
 */
function wbik_starter_build() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do that.', 'wisebones-industry-kit' ) );
	}
	check_admin_referer( 'wbik_starter_build' );

	$plan = wbik_starter_plan();
	$log  = get_option( 'wbik_starter_log', array() );
	$log  = wp_parse_args(
		is_array( $log ) ? $log : array(),
		array(
			'posts' => array(),
			'terms' => array(),
			'menu'  => 0,
			'prev'  => array(),
		)
	);
	$mark = static function ( $post_id ) use ( &$log ) {
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_wbik_starter', get_post_field( 'post_modified_gmt', $post_id ) );
			$log['posts'][] = (int) $post_id;
		}
	};

	// Pages.
	$pages = array();
	foreach ( (array) $plan['pages'] as $slug => $page ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$pages[ $slug ] = $existing->ID;
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $page['title'],
				'post_content' => isset( $page['content'] ) ? $page['content'] : '',
			),
			true
		);
		if ( ! is_wp_error( $id ) ) {
			$pages[ $slug ] = $id;
			if ( ! empty( $page['template'] ) ) {
				update_post_meta( $id, '_wp_page_template', sanitize_text_field( $page['template'] ) );
			}
			$mark( $id );
		}
	}

	// Front page and posts page.
	if ( empty( $log['prev'] ) ) {
		$log['prev'] = array(
			'show_on_front'  => get_option( 'show_on_front' ),
			'page_on_front'  => (int) get_option( 'page_on_front' ),
			'page_for_posts' => (int) get_option( 'page_for_posts' ),
		);
	}
	if ( ! empty( $pages[ $plan['front'] ] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages[ $plan['front'] ] );
	}
	if ( $plan['blog'] && ! empty( $pages[ $plan['blog'] ] ) ) {
		update_option( 'page_for_posts', $pages[ $plan['blog'] ] );
	}

	// Services.
	if ( wbik_type_enabled( 'service' ) && ! get_posts( array( 'post_type' => 'wbik_service', 'posts_per_page' => 1, 'post_status' => 'any', 'fields' => 'ids' ) ) ) { // phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound
		foreach ( array_values( (array) $plan['services'] ) as $order => $service ) {
			$id = wp_insert_post(
				array(
					'post_type'    => 'wbik_service',
					'post_status'  => 'publish',
					'post_title'   => $service[1],
					'post_excerpt' => $service[2],
					'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $service[2] ) . '</p><!-- /wp:paragraph -->',
					'menu_order'   => $order,
				),
				true
			);
			if ( ! is_wp_error( $id ) ) {
				update_post_meta( $id, '_wbik_icon', sanitize_html_class( $service[0] ) );
				$mark( $id );
			}
		}
	}

	// Terms.
	$terms = (array) $plan['terms'];
	if ( $plan['areas'] ) {
		$terms['wbik_area'] = array_merge( isset( $terms['wbik_area'] ) ? (array) $terms['wbik_area'] : array(), (array) $plan['areas'] );
	}
	foreach ( $terms as $taxonomy => $names ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}
		foreach ( (array) $names as $name ) {
			if ( term_exists( $name, $taxonomy ) ) {
				continue;
			}
			$term = wp_insert_term( $name, $taxonomy );
			if ( ! is_wp_error( $term ) ) {
				$log['terms'][] = array( $taxonomy, (int) $term['term_id'] );
			}
		}
	}

	// Samples, as drafts.
	if ( ! empty( $_POST['samples'] ) ) {
		foreach ( (array) $plan['samples'] as $type => $samples ) {
			if ( ! wbik_type_enabled( $type ) ) {
				continue;
			}
			foreach ( (array) $samples as $sample ) {
				if ( 'testimonial' === $type ) {
					$postarr = array(
						'post_title'   => $sample[1],
						'post_content' => $sample[0],
					);
					$meta    = array(
						'author_name' => $sample[1],
						'author_role' => isset( $sample[2] ) ? $sample[2] : '',
						'rating'      => '5',
					);
				} else {
					$postarr = array(
						'post_title'   => $sample['title'],
						'post_excerpt' => isset( $sample['excerpt'] ) ? $sample['excerpt'] : '',
					);
					$meta    = array_intersect_key( $sample, wbik_fields( $type ) );
				}
				$id = wp_insert_post(
					array_merge(
						$postarr,
						array(
							'post_type'   => 'wbik_' . $type,
							'post_status' => 'draft',
						)
					),
					true
				);
				if ( is_wp_error( $id ) ) {
					continue;
				}
				foreach ( $meta as $key => $value ) {
					$field = wbik_fields( $type )[ $key ];
					update_post_meta( $id, '_wbik_' . $key, wbik_sanitize_field( $value, $field ) );
				}
				$mark( $id );
			}
		}
	}

	// Menu.
	if ( $plan['menu'] && ! $log['menu'] ) {
		$name = __( 'Main menu', 'wisebones-industry-kit' );
		$menu = wp_get_nav_menu_object( $name );
		$menu = $menu ? (int) $menu->term_id : wp_create_nav_menu( $name );
		if ( $menu && ! is_wp_error( $menu ) ) {
			foreach ( (array) $plan['menu'] as $position => $item ) {
				$def = wbik_starter_menu_item( (string) $item[1], $pages );
				if ( $def ) {
					wp_update_nav_menu_item(
						$menu,
						0,
						array_merge(
							$def,
							array(
								'menu-item-title'    => $item[0],
								'menu-item-status'   => 'publish',
								'menu-item-position' => $position + 1,
							)
						)
					);
				}
			}
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations            = is_array( $locations ) ? $locations : array();
			$log['prev']['menus'] = $locations;
			$locations['primary'] = $menu;
			set_theme_mod( 'nav_menu_locations', $locations );
			$log['menu'] = $menu;
		}
	}

	$log['posts'] = array_values( array_unique( $log['posts'] ) );
	update_option( 'wbik_starter_log', $log, false );
	flush_rewrite_rules();

	wp_safe_redirect( admin_url( 'themes.php?page=wbik-starter&wbik_done=built' ) );
	exit;
}

add_action( 'admin_post_wbik_starter_remove', 'wbik_starter_remove' );

/**
 * Remove what the builder created, keeping anything edited since.
 */
function wbik_starter_remove() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do that.', 'wisebones-industry-kit' ) );
	}
	check_admin_referer( 'wbik_starter_remove' );

	$log = get_option( 'wbik_starter_log', array() );
	$log = is_array( $log ) ? $log : array();

	foreach ( isset( $log['posts'] ) ? (array) $log['posts'] : array() as $post_id ) {
		$stamp = get_post_meta( $post_id, '_wbik_starter', true );
		if ( $stamp && get_post_field( 'post_modified_gmt', $post_id ) === $stamp ) {
			wp_delete_post( $post_id, true );
		}
	}
	foreach ( isset( $log['terms'] ) ? (array) $log['terms'] : array() as $term ) {
		$found = get_term( (int) $term[1], $term[0] );
		if ( $found && ! is_wp_error( $found ) && 0 === (int) $found->count ) {
			wp_delete_term( (int) $term[1], $term[0] );
		}
	}
	if ( ! empty( $log['menu'] ) ) {
		wp_delete_nav_menu( (int) $log['menu'] );
		if ( isset( $log['prev']['menus'] ) ) {
			set_theme_mod( 'nav_menu_locations', (array) $log['prev']['menus'] );
		}
	}
	if ( ! empty( $log['prev'] ) ) {
		$front = (int) $log['prev']['page_on_front'];
		update_option( 'show_on_front', $log['prev']['show_on_front'] ? $log['prev']['show_on_front'] : 'posts' );
		update_option( 'page_on_front', $front && get_post( $front ) ? $front : 0 );
		update_option( 'page_for_posts', (int) $log['prev']['page_for_posts'] && get_post( (int) $log['prev']['page_for_posts'] ) ? (int) $log['prev']['page_for_posts'] : 0 );
	}

	delete_option( 'wbik_starter_log' );
	wp_safe_redirect( admin_url( 'themes.php?page=wbik-starter&wbik_done=removed' ) );
	exit;
}
