<?php
/**
 * Bootstrap 5 nav walker and menu helpers.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bootstrap 5 Nav Walker
 * Renders WordPress nav menus as Bootstrap 5 navbars with dropdowns.
 */
class WPWISEBONES_Bootstrap_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="dropdown-menu">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_child = in_array( 'menu-item-has-children', $classes, true );

		if ( 0 === $depth ) {
			$li_class = 'nav-item' . ( $has_child ? ' dropdown' : '' );
			$output  .= '<li class="' . esc_attr( $li_class ) . '">';

			$a_class = 'nav-link' . ( $has_child ? ' dropdown-toggle' : '' );
			if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) ) {
				$a_class .= ' active';
			}

			$atts          = array();
			$atts['href']  = ! empty( $item->url ) ? $item->url : '#';
			$atts['class'] = $a_class;

			if ( $has_child ) {
				$atts['data-bs-toggle'] = 'dropdown';
				$atts['aria-expanded']  = 'false';
			}

			$title   = apply_filters( 'the_title', $item->title, $item->ID );
			$output .= '<a' . $this->build_atts( $atts ) . '>' . esc_html( $title ) . '</a>';
		} else {
			$a_class = 'dropdown-item';
			$output .= '<li>';
			$atts    = array(
				'href'  => ! empty( $item->url ) ? $item->url : '#',
				'class' => $a_class,
			);
			$title   = apply_filters( 'the_title', $item->title, $item->ID );
			$output .= '<a' . $this->build_atts( $atts ) . '>' . esc_html( $title ) . '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}

	protected function build_atts( $atts = array() ): string {
		$html = '';
		foreach ( $atts as $key => $val ) {
			$html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
		}
		return $html;
	}
}

/**
 * Helper: render primary nav.
 */
function wpwisebones_primary_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0',
			'fallback_cb'    => 'wpwisebones_fallback_menu',
			'walker'         => new WPWISEBONES_Bootstrap_Nav_Walker(),
		)
	);
}

/**
 * Helper: render footer nav inline.
 */
function wpwisebones_footer_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'footer',
			'container'      => false,
			'menu_class'     => 'd-flex flex-wrap gap-3 list-unstyled mb-0',
			'depth'          => 1,
			'fallback_cb'    => false,
			'walker'         => new WPWISEBONES_Bootstrap_Nav_Walker(),
		)
	);
}

/**
 * Fallback when no menu is assigned.
 */
function wpwisebones_fallback_menu() {
	echo '<ul class="navbar-nav me-auto">';
	echo '<li class="nav-item"><a class="nav-link" href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'wpwisebones' ) . '</a></li>';
	echo '</ul>';
}
