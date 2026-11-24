<?php
/**
 * The site's menus, built once.
 *
 * @package Antivig
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

/**
 * Build the primary and legal menus if the site has none.
 *
 * Without an assigned menu the parent falls back to listing every published
 * page, which on this site means the board sitting next to "Sample Page" and
 * the privacy policy. That is the first thing a visitor sees, so the theme
 * builds a sensible menu rather than waiting for somebody to notice.
 *
 * It runs once — recorded in an option — and never fights an owner who then
 * edits it. Pages that do not exist yet are skipped rather than linked into a
 * 404, so running it again after the plugins create their pages fills the gaps.
 *
 * @return void
 */
function antivig_build_menus(): void {
	if ( ! is_admin() ) {
		return;
	}

	$built = (array) get_option( 'antivig_menus_built', array() );

	$menus = array(
		'antivig-primary' => array(
			'location' => 'primary',
			'name'     => __( 'Primary', 'antivig-child' ),
			'items'    => array(
				'today'      => __( 'Board', 'antivig-child' ),
				'ledger'     => __( 'Record', 'antivig-child' ),
				'membership' => __( 'Plans', 'antivig-child' ),
				'account'    => __( 'Account', 'antivig-child' ),
			),
		),
		'antivig-legal'   => array(
			'location' => 'antivig-legal',
			'name'     => __( 'Legal', 'antivig-child' ),
			'items'    => array(
				'privacy-policy' => __( 'Privacy', 'antivig-child' ),
			),
		),
	);

	foreach ( $menus as $slug => $menu ) {
		$known = isset( $built[ $slug ] ) && is_nav_menu( (int) $built[ $slug ] );

		if ( $known ) {
			$menu_id = (int) $built[ $slug ];
		} else {
			$existing = wp_get_nav_menu_object( $menu['name'] );
			$menu_id  = $existing ? (int) $existing->term_id : (int) wp_create_nav_menu( $menu['name'] );
		}

		if ( $menu_id <= 0 ) {
			continue;
		}

		$items   = wp_get_nav_menu_items( $menu_id );
		$items   = is_array( $items ) ? $items : array();
		$present = array();

		foreach ( $items as $item ) {
			// An item added before its page was unpublished — or added by an
			// earlier version of this code, which did not check — is removed
			// rather than left pointing at a 404.
			if ( 'post_type' === $item->type && 'publish' !== get_post_status( (int) $item->object_id ) ) {
				wp_delete_post( (int) $item->ID, true );
				continue;
			}

			$present[] = (int) $item->object_id;
		}

		foreach ( $menu['items'] as $page_slug => $label ) {
			$page = get_page_by_path( $page_slug );

			if ( ! $page instanceof WP_Post || in_array( $page->ID, $present, true ) ) {
				continue;
			}

			/*
			 * Only ever link a published page. A menu item pointing at a draft
			 * renders as `?page_id=N`, which is a 404 for everybody who is not
			 * signed in — and the item this caught was Privacy, in the footer,
			 * on every page of a site that takes money. Items are reconciled on
			 * every pass rather than only at first build, so the link appears by
			 * itself the moment the page is published.
			 */
			if ( 'publish' !== $page->post_status ) {
				continue;
			}

			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'     => $label,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $page->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);
		}

		$locations = (array) get_theme_mod( 'nav_menu_locations', array() );

		if ( empty( $locations[ $menu['location'] ] ) ) {
			$locations[ $menu['location'] ] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		$built[ $slug ] = $menu_id;
	}

	update_option( 'antivig_menus_built', $built, false );
}
add_action( 'admin_init', 'antivig_build_menus' );
