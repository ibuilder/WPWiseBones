<?php
/**
 * Becoming - child theme of WPWiseBones.
 *
 * A trans-pride skin for the community platform built on the tw-* plugins
 * (tw-core, tw-journey, tw-photos, tw-funding, tw-verify, tw-resources,
 * tw-safety, tw-looklab).
 *
 * @package Becoming
 */

defined( 'ABSPATH' ) || exit;

define( 'BECOMING_VERSION', '1.0.0' );

/* Print the active theme version into <head> so you can confirm which build is
   live from "View Source" (search for "Becoming theme v"). */
add_action(
	'wp_head',
	function () {
		echo "\n<!-- Becoming theme v" . esc_html( BECOMING_VERSION ) . " -->\n";
	},
	1
);

/**
 * Cache-bust by file modification time, so an edit is visible on reload.
 *
 * @param string $rel Path relative to the child theme directory.
 * @return string
 */
function becoming_asset_version( $rel ) {
	$path = get_stylesheet_directory() . $rel;

	return file_exists( $path ) ? (string) filemtime( $path ) : BECOMING_VERSION;
}

/* ---------------------------------------------------------------------------
 * Assets
 * ------------------------------------------------------------------------- */

add_action(
	'wp_enqueue_scripts',
	function () {
		/*
		 * Force tw-core's front-end floor into the <head>.
		 *
		 * tw-front.css is registered lazily - the first tw-* shortcode to
		 * render calls tw_enqueue_front_styles(). That happens during
		 * the_content, long after wp_head has been printed, so WordPress emits
		 * it in the footer. A stylesheet in the footer wins every tie against
		 * one in the head, which would mean the floor silently overriding the
		 * theme on exactly the components the theme most wants to style.
		 *
		 * Calling it here registers and enqueues it during wp_enqueue_scripts
		 * instead, so it lands in the head, in front of the brand stylesheet,
		 * and the cascade runs floor -> theme as intended. The cost is one
		 * small stylesheet on pages that have no tw-* shortcode at all.
		 */
		if ( function_exists( 'tw_enqueue_front_styles' ) ) {
			tw_enqueue_front_styles();
		}

		/*
		 * Depend on the parent's real handles. Note that 'wpwisebones-style'
		 * resolves to THIS theme's style.css once the child is active, and
		 * that the parent's own style.css is therefore not loaded at all -
		 * assets/css/becoming.css carries the chrome that file used to.
		 */
		$deps = array();

		foreach ( array( 'wpwisebones-style', 'wpwisebones-main', 'tw-front' ) as $handle ) {
			if ( wp_style_is( $handle, 'registered' ) || wp_style_is( $handle, 'enqueued' ) ) {
				$deps[] = $handle;
			}
		}

		wp_enqueue_style(
			'becoming-brand',
			get_stylesheet_directory_uri() . '/assets/css/becoming.css',
			$deps,
			becoming_asset_version( '/assets/css/becoming.css' )
		);

		wp_enqueue_script(
			'becoming-ui',
			get_stylesheet_directory_uri() . '/assets/js/becoming.js',
			array(),
			becoming_asset_version( '/assets/js/becoming.js' ),
			true
		);
	},
	20
);

/*
 * Apply the stored colour-scheme choice before first paint.
 *
 * This has to be inline and synchronous. An external script, or a deferred
 * one, runs after the first paint and the visitor sees a flash of the wrong
 * theme. It is four lines and it is wrapped in try/catch because localStorage
 * throws rather than returning null in a private window with site data
 * blocked.
 */
add_action(
	'wp_head',
	function () {
		?>
<script>
(function(){try{var t=localStorage.getItem('bc-theme');if(t==='dark'||t==='light'){document.documentElement.setAttribute('data-theme',t);}}catch(e){}})();
</script>
		<?php
	},
	2
);

/* ---------------------------------------------------------------------------
 * Brand the parent's customizer output
 *
 * The parent prints inline CSS from theme mods at priority 99 (see
 * inc/customizer.php). Setting the defaults here means that output is already
 * on-brand - --bs-primary in particular, which Bootstrap components this theme
 * does not style explicitly still read from.
 * ------------------------------------------------------------------------- */

add_filter( 'theme_mod_wpwisebones_color_primary', fn( $v ) => $v ? $v : '#0b5f85' );
add_filter( 'theme_mod_wpwisebones_color_secondary', fn( $v ) => $v ? $v : '#5a5560' );
add_filter( 'theme_mod_wpwisebones_color_accent', fn( $v ) => $v ? $v : '#b21f49' );

/* ---------------------------------------------------------------------------
 * Full width by default
 *
 * The parent defaults to a right sidebar, and wpwisebones_has_sidebar()
 * returns true on ANY singular page whether or not the sidebar holds a single
 * widget - so an empty sidebar does not collapse, it just takes a third of the
 * page and leaves it blank while the content sits in col-lg-8.
 *
 * Every page on this platform is a grid: a photo timeline, a milestone
 * library, a resource directory. They want the width. So the theme's default
 * is full-width, and an explicit choice in the customizer still wins - hence
 * reading get_theme_mods() rather than trusting the filtered value, which
 * cannot tell "never set" from "deliberately set to right-sidebar".
 * ------------------------------------------------------------------------- */

add_filter(
	'theme_mod_wpwisebones_layout',
	function ( $value ) {
		$mods = get_theme_mods();

		if ( is_array( $mods ) && array_key_exists( 'wpwisebones_layout', $mods ) ) {
			return $value;
		}

		return 'full-width';
	}
);

/* ---------------------------------------------------------------------------
 * Editor
 * ------------------------------------------------------------------------- */

add_action(
	'after_setup_theme',
	function () {
		/*
		 * The palette offers the flag colours as backgrounds, which is where
		 * they are legible: plum ink on flag rose is 9.91:1 and on flag sky
		 * 10.26:1. The two "deep" entries are the text-safe versions - 7.02:1
		 * and 6.59:1 on white - because flag sky and flag rose as TEXT on
		 * white are 1.80:1 and 1.87:1 and must not be offered for that.
		 */
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Flag sky', 'becoming' ),
					'slug'  => 'primary',
					'color' => '#5bcefa',
				),
				array(
					'name'  => __( 'Flag rose', 'becoming' ),
					'slug'  => 'secondary',
					'color' => '#f5a9b8',
				),
				array(
					'name'  => __( 'Deep sky (text safe)', 'becoming' ),
					'slug'  => 'deep-sky',
					'color' => '#0b5f85',
				),
				array(
					'name'  => __( 'Deep rose (text safe)', 'becoming' ),
					'slug'  => 'deep-rose',
					'color' => '#b21f49',
				),
				array(
					'name'  => __( 'Plum ink', 'becoming' ),
					'slug'  => 'dark',
					'color' => '#16121a',
				),
				array(
					'name'  => __( 'Sky wash', 'becoming' ),
					'slug'  => 'light',
					'color' => '#f1fafe',
				),
				array(
					'name'  => __( 'White', 'becoming' ),
					'slug'  => 'white',
					'color' => '#ffffff',
				),
			)
		);

		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/becoming.css' );

		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style', 'navigation-widgets' ) );

		load_child_theme_textdomain( 'becoming', get_stylesheet_directory() . '/languages' );
	},
	20
);

/* ---------------------------------------------------------------------------
 * Navigation walker
 *
 * The parent's WPWISEBONES_Bootstrap_Nav_Walker builds its own <li> class
 * string from scratch - 'nav-item', plus 'dropdown' when the item has children
 * - and never looks at $item->classes. So any class typed into the "CSS
 * Classes" field in Appearance > Menus is silently discarded, and the standard
 * nav_menu_css_class filter has nothing to act on either.
 *
 * This subclass keeps the parent's markup exactly and adds those classes back.
 * It is declared on after_setup_theme because WordPress loads the CHILD's
 * functions.php first - the parent class does not exist yet while this file is
 * being parsed, so `extends` at the top level would fatal.
 * ------------------------------------------------------------------------- */

add_action(
	'after_setup_theme',
	function () {
		if ( ! class_exists( 'WPWISEBONES_Bootstrap_Nav_Walker' ) || class_exists( 'Becoming_Nav_Walker' ) ) {
			return;
		}

		/**
		 * Nav walker that preserves per-item CSS classes.
		 */
		class Becoming_Nav_Walker extends WPWISEBONES_Bootstrap_Nav_Walker {

			/**
			 * Open one element.
			 *
			 * @param string $output Walker output, by reference.
			 * @param object $item   Menu item.
			 * @param int    $depth  Depth.
			 * @param array  $args   Args.
			 * @param int    $id     Item id.
			 * @return void
			 */
			public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
				$before = strlen( $output );

				parent::start_el( $output, $item, $depth, $args, $id );

				$custom = array_filter(
					(array) ( empty( $item->classes ) ? array() : $item->classes ),
					static function ( $class ) {
						// The generated ones are already on the element.
						return '' !== $class && 0 !== strpos( $class, 'menu-item' );
					}
				);

				if ( ! $custom ) {
					return;
				}

				$fragment = substr( $output, $before );
				$extra    = esc_attr( implode( ' ', array_map( 'sanitize_html_class', $custom ) ) );

				// Only the <li> this call just opened, and only its first class attribute.
				$patched = preg_replace(
					'/^<li class="([^"]*)"/',
					'<li class="$1 ' . $extra . '"',
					$fragment,
					1
				);

				if ( null !== $patched ) {
					$output = substr( $output, 0, $before ) . $patched;
				}
			}
		}
	},
	5
);

/**
 * Render the primary navigation with the child's walker.
 *
 * Mirrors wpwisebones_primary_nav() - the parent hardcodes its own walker, so
 * there is no filter to swap it through.
 *
 * @return void
 */
function becoming_primary_nav() {
	$walker = class_exists( 'Becoming_Nav_Walker' )
		? new Becoming_Nav_Walker()
		: ( class_exists( 'WPWISEBONES_Bootstrap_Nav_Walker' ) ? new WPWISEBONES_Bootstrap_Nav_Walker() : '' );

	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'navbar-nav',
			'fallback_cb'    => function_exists( 'wpwisebones_fallback_menu' ) ? 'wpwisebones_fallback_menu' : false,
			'walker'         => $walker,
		)
	);
}

/* ---------------------------------------------------------------------------
 * Body class
 * ------------------------------------------------------------------------- */

add_filter(
	'body_class',
	function ( $classes ) {
		$classes[] = 'becoming';

		return $classes;
	}
);

/* ---------------------------------------------------------------------------
 * Page head
 *
 * Rendered by header.php. Kept in a function so a page template can call it
 * with its own copy, and so the markup is in one place.
 * ------------------------------------------------------------------------- */

/**
 * The eyebrow line above a page title.
 *
 * @return string
 */
function becoming_pagehead_eyebrow() {
	if ( is_front_page() ) {
		return (string) get_bloginfo( 'description' );
	}

	if ( is_singular() ) {
		/*
		 * Only for custom post types. On an ordinary page the label is "Page",
		 * which tells the reader nothing they cannot see - and an eyebrow that
		 * says nothing is worse than no eyebrow, because it still costs a line
		 * and a glance. On a funding request or a resource it is useful.
		 */
		$type = get_post_type_object( get_post_type() );

		if ( $type && ! in_array( get_post_type(), array( 'page', 'post' ), true ) && ! empty( $type->labels->singular_name ) ) {
			return (string) $type->labels->singular_name;
		}

		return '';
	}

	if ( is_archive() ) {
		return (string) get_the_archive_title();
	}

	if ( is_search() ) {
		return __( 'Search', 'becoming' );
	}

	return '';
}

/**
 * Print the page head: eyebrow, title, aurora.
 *
 * @return void
 */
function becoming_pagehead() {
	$eyebrow = becoming_pagehead_eyebrow();
	$title   = '';

	if ( is_singular() ) {
		$title = (string) get_the_title();
	} elseif ( is_front_page() || is_home() ) {
		$title   = (string) get_bloginfo( 'name' );
		$eyebrow = (string) get_bloginfo( 'description' );
	} elseif ( is_archive() ) {
		$title   = (string) get_the_archive_title();
		$eyebrow = '';
	} elseif ( is_search() ) {
		/* translators: %s: the search terms. */
		$title   = sprintf( __( 'Results for %s', 'becoming' ), get_search_query() );
		$eyebrow = __( 'Search', 'becoming' );
	} elseif ( is_404() ) {
		$title   = __( 'Nothing here', 'becoming' );
		$eyebrow = '';
	}

	if ( '' === trim( $title ) ) {
		return;
	}

	$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
	?>
	<div class="bc-pagehead-wrap bc-stage">
		<div class="bc-aurora" aria-hidden="true"><span></span><span></span><span></span></div>
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="bc-pagehead">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="bc-eyebrow"><?php echo esc_html( wp_strip_all_tags( $eyebrow ) ); ?></p>
				<?php endif; ?>
				<h1 class="bc-gradient-text"><?php echo esc_html( $title ); ?></h1>
			</div>
		</div>
	</div>
	<?php
}

/* ---------------------------------------------------------------------------
 * One title per page
 *
 * becoming_pagehead() prints the <h1>, and the parent's content-page template
 * prints another one. Hiding the second in CSS would be the wrong fix: it
 * stays in the accessibility tree, so a screen reader announces the same
 * heading twice while a sighted visitor sees it once.
 *
 * The parent already has the switch for this - content-page.php reads the
 * _wpwisebones_hide_title post meta - so filtering that meta removes the
 * duplicate from the markup entirely. An editor who sets the meta themselves
 * still gets what they asked for, because this only ever forces it on.
 * ------------------------------------------------------------------------- */

add_filter(
	'get_post_metadata',
	function ( $value, $object_id, $meta_key, $single ) {
		if ( '_wpwisebones_hide_title' !== $meta_key || is_admin() ) {
			return $value;
		}

		// Only while rendering the page whose head we have just printed.
		if ( ! is_singular() || get_queried_object_id() !== (int) $object_id ) {
			return $value;
		}

		return $single ? '1' : array( '1' );
	},
	10,
	4
);

/* ---------------------------------------------------------------------------
 * Section navigation
 *
 * Every module page lives inside a dropdown group, and until now the only way
 * from "My journey" to "Milestones" was to reopen the dropdown you had just
 * closed. That is two deliberate actions to move between two halves of the
 * same thing, and on a phone it is two actions behind a burger.
 *
 * So a page that sits inside a group gets its siblings printed under the
 * title. It is built from the primary menu rather than from a new setting,
 * which means the sections are whatever Appearance > Menus says they are and
 * there is nothing to keep in sync.
 *
 * Deliberately absent on the childless top-level items - Help, Safety, Look
 * Lab. A row containing one link is not navigation, it is furniture.
 * ------------------------------------------------------------------------- */

/**
 * The primary menu's items, or an empty array.
 *
 * @return array
 */
function becoming_primary_menu_items() {
	$locations = get_nav_menu_locations();

	if ( empty( $locations['primary'] ) ) {
		return array();
	}

	$items = wp_get_nav_menu_items( (int) $locations['primary'] );

	return is_array( $items ) ? $items : array();
}

/**
 * The siblings of the current page within its menu group.
 *
 * @return array{label: string, items: array} Empty label and items when the
 *                                            current page is not in a group.
 */
function becoming_section() {
	$empty = array(
		'label' => '',
		'items' => array(),
	);

	if ( ! is_singular() ) {
		return $empty;
	}

	$current = get_queried_object_id();
	$items   = becoming_primary_menu_items();

	if ( $current <= 0 || empty( $items ) ) {
		return $empty;
	}

	$mine = null;

	foreach ( $items as $item ) {
		if ( (int) $item->object_id === $current && 'post_type' === $item->type ) {
			$mine = $item;
			break;
		}
	}

	// Not in the menu at all, or in it at the top level with no siblings.
	if ( ! $mine || 0 === (int) $mine->menu_item_parent ) {
		return $empty;
	}

	$parent_id = (int) $mine->menu_item_parent;
	$siblings  = array();
	$label     = '';

	foreach ( $items as $item ) {
		if ( (int) $item->ID === $parent_id ) {
			$label = (string) $item->title;
		}

		if ( (int) $item->menu_item_parent === $parent_id ) {
			$siblings[] = $item;
		}
	}

	if ( count( $siblings ) < 2 ) {
		return $empty;
	}

	return array(
		'label' => $label,
		'items' => $siblings,
	);
}

/**
 * Print the section navigation, if the current page has one.
 *
 * @return void
 */
function becoming_section_nav() {
	$section = becoming_section();

	if ( empty( $section['items'] ) ) {
		return;
	}

	$current   = get_queried_object_id();
	$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
	?>
	<div class="bc-sectionnav-wrap">
		<div class="<?php echo esc_attr( $container ); ?>">
			<nav class="bc-sectionnav" aria-label="<?php echo esc_attr( $section['label'] ? $section['label'] : __( 'Section', 'becoming' ) ); ?>">
				<?php if ( '' !== $section['label'] ) : ?>
					<span class="bc-sectionnav-label"><?php echo esc_html( $section['label'] ); ?></span>
				<?php endif; ?>

				<ul>
					<?php foreach ( $section['items'] as $item ) : ?>
						<?php $is_current = ( (int) $item->object_id === $current ); ?>
						<li>
							<a href="<?php echo esc_url( $item->url ); ?>"
								class="bc-sectionnav-link<?php echo $is_current ? ' is-current' : ''; ?>"
								<?php echo $is_current ? 'aria-current="page"' : ''; ?>>
								<?php echo esc_html( $item->title ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>
	</div>
	<?php
}
