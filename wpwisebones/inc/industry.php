<?php
/**
 * Industry front-page framework.
 *
 * A child theme opts in by shipping an `industry-config.php` that returns an
 * array (see child-themes/README.md for the full schema). The parent then:
 *
 *  - renders the front page from an ordered list of sections, each one a
 *    template part in template-parts/industry/ that a child can override by
 *    placing a file at the same path;
 *  - applies the config's brand colours and header style as *defaults* for the
 *    existing Customizer settings, so the owner can still change them;
 *  - enqueues assets/css/industry.css, which the child skins with CSS custom
 *    properties in its own style.css;
 *  - adds a Customizer section to toggle sections and edit the stats strip,
 *    hero eyebrow and closing call to action without touching code;
 *  - declares `wisebones-industry` theme support, which the WiseBones Industry
 *    Kit plugin reads to decide which content types (listings, projects,
 *    services, team, testimonials, service areas) to register.
 *
 * Nothing here runs for the parent on its own or for a child theme without an
 * industry-config.php, so existing child themes are unaffected.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

/**
 * The sections the framework knows how to render, in their default order.
 *
 * @return string[]
 */
function wpwisebones_industry_known_sections(): array {
	return array( 'hero', 'stats', 'services', 'featured', 'values', 'process', 'team', 'testimonials', 'areas', 'faq', 'content', 'posts', 'cta' );
}

/**
 * The active child theme's industry config, normalised. Empty array when the
 * active theme is not an industry theme.
 *
 * Loaded once, lazily. The first call happens during after_setup_theme, which
 * is early enough for theme supports and late enough for translations.
 *
 * @return array
 */
function wpwisebones_industry_config(): array {
	static $config = null;
	if ( null !== $config ) {
		return $config;
	}
	$config = array();

	$file = get_stylesheet_directory() . '/industry-config.php';
	if ( is_child_theme() && file_exists( $file ) ) {
		$raw = include $file;
		if ( is_array( $raw ) ) {
			$config = $raw;
		}
	}

	/**
	 * Filters the industry config. Use it from a grandchild-style plugin or a
	 * child's functions.php to change copy, sections or samples without
	 * forking the config file.
	 *
	 * @param array $config Raw config returned by industry-config.php.
	 */
	$config = (array) apply_filters( 'wpwisebones_industry_config', $config );
	if ( empty( $config ) ) {
		return $config;
	}

	$config = wp_parse_args(
		$config,
		array(
			'id'            => get_stylesheet(),
			'family'        => 'general',
			'label'         => '',
			'schema'        => 'LocalBusiness',
			'content_types' => array( 'service', 'testimonial' ),
			'labels'        => array(),
			'lead_type'     => 'contact',
			'colors'        => array(),
			'header_style'  => 'light',
			'header_cta'    => array(),
			'hero'          => array(),
			'stats'         => array(),
			'sections'      => array(),
			'order'         => array( 'hero', 'stats', 'services', 'featured', 'process', 'testimonials', 'cta' ),
			'footer'        => array(),
			'starter'       => array(),
		)
	);

	$config['order'] = array_values( array_intersect( (array) $config['order'], wpwisebones_industry_known_sections() ) );
	return $config;
}

/**
 * Whether the active theme is an industry theme.
 */
function wpwisebones_is_industry(): bool {
	return ! empty( wpwisebones_industry_config() );
}

/**
 * One section's config array.
 *
 * @param string $name Section name.
 */
function wpwisebones_industry_section( string $name ): array {
	$config = wpwisebones_industry_config();
	if ( 'hero' === $name ) {
		return (array) $config['hero'];
	}
	return isset( $config['sections'][ $name ] ) ? (array) $config['sections'][ $name ] : array();
}

/**
 * Resolve a config URL: '/path/' becomes a home URL, '#anchor' and absolute
 * URLs pass through.
 *
 * @param string $url Config URL.
 */
function wpwisebones_industry_url( string $url ): string {
	if ( '' === $url ) {
		return home_url( '/' );
	}
	if ( '#' === $url[0] || preg_match( '#^(https?:|mailto:|tel:)#i', $url ) ) {
		return $url;
	}
	return home_url( '/' . ltrim( $url, '/' ) );
}

/**
 * Whether the current viewer may see sample content. Samples fill empty
 * sections so the owner can see the layout; visitors never see them.
 */
function wpwisebones_industry_can_preview(): bool {
	return current_user_can( 'edit_theme_options' ) || is_customize_preview();
}

/**
 * Post type name the Industry Kit plugin registers for a content type.
 *
 * @param string $type listing|project|service|team|testimonial.
 */
function wpwisebones_industry_post_type( string $type ): string {
	return 'wbik_' . sanitize_key( $type );
}

/**
 * Published entries of a kit content type, or an empty array when the plugin
 * is inactive or nothing is published yet.
 *
 * @param string $type  Content type.
 * @param int    $count How many.
 * @param array  $args  Extra WP_Query args.
 * @return WP_Post[]
 */
function wpwisebones_industry_items( string $type, int $count = 3, array $args = array() ): array {
	$post_type = wpwisebones_industry_post_type( $type );
	if ( ! post_type_exists( $post_type ) ) {
		return array();
	}
	$query = new WP_Query(
		array_merge(
			array(
				'post_type'           => $post_type,
				'posts_per_page'      => $count,
				'post_status'         => 'publish',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
				'orderby'             => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
			),
			$args
		)
	);
	return $query->posts;
}

/**
 * A kit meta value. Keys are documented in the Industry Kit readme; the kit
 * stores them with a leading underscore.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Field key without the prefix, e.g. 'price'.
 */
function wpwisebones_industry_meta( int $post_id, string $key ): string {
	$value = get_post_meta( $post_id, '_wbik_' . $key, true );
	return (string) apply_filters( 'wpwisebones_industry_meta', is_scalar( $value ) ? (string) $value : '', $post_id, $key );
}

/**
 * The label for a kit content type, honouring the theme's relabelling (a
 * property manager calls listings "Rentals").
 *
 * @param string $type     Content type.
 * @param bool   $singular Singular instead of plural.
 */
function wpwisebones_industry_type_label( string $type, bool $singular = false ): string {
	$config   = wpwisebones_industry_config();
	$defaults = array(
		'listing'     => array( __( 'Listings', 'wpwisebones' ), __( 'Listing', 'wpwisebones' ) ),
		'project'     => array( __( 'Projects', 'wpwisebones' ), __( 'Project', 'wpwisebones' ) ),
		'service'     => array( __( 'Services', 'wpwisebones' ), __( 'Service', 'wpwisebones' ) ),
		'team'        => array( __( 'Team', 'wpwisebones' ), __( 'Team member', 'wpwisebones' ) ),
		'testimonial' => array( __( 'Testimonials', 'wpwisebones' ), __( 'Testimonial', 'wpwisebones' ) ),
	);
	$pair     = isset( $config['labels'][ $type ] ) ? (array) $config['labels'][ $type ] : ( isset( $defaults[ $type ] ) ? $defaults[ $type ] : array( ucfirst( $type ), ucfirst( $type ) ) );
	return (string) ( $singular ? ( isset( $pair[1] ) ? $pair[1] : $pair[0] ) : $pair[0] );
}

/**
 * Whether a section is switched on in the Customizer. Every section in the
 * config's order is on until the owner turns it off.
 *
 * @param string $name Section name.
 */
function wpwisebones_industry_section_enabled( string $name ): bool {
	return (bool) get_theme_mod( 'wpwisebones_ind_show_' . $name, true );
}

/**
 * Print the front page: every enabled section in config order.
 */
function wpwisebones_industry_front_page() {
	$config = wpwisebones_industry_config();
	foreach ( $config['order'] as $name ) {
		if ( ! wpwisebones_industry_section_enabled( $name ) ) {
			continue;
		}
		get_template_part(
			'template-parts/industry/section',
			$name,
			array(
				'name'    => $name,
				'section' => wpwisebones_industry_section( $name ),
				'config'  => $config,
			)
		);
	}
}

/**
 * Section heading block shared by most sections.
 *
 * @param array  $section Section config (eyebrow, heading, text).
 * @param string $align   'center' or 'start'.
 */
function wpwisebones_industry_heading( array $section, string $align = 'center' ) {
	if ( empty( $section['heading'] ) && empty( $section['eyebrow'] ) ) {
		return;
	}
	$class = 'center' === $align ? 'wpb-ind-head text-center mx-auto' : 'wpb-ind-head';
	?>
	<header class="<?php echo esc_attr( $class ); ?>">
		<?php if ( ! empty( $section['eyebrow'] ) ) : ?>
			<span class="wpb-ind-eyebrow"><?php echo esc_html( $section['eyebrow'] ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $section['heading'] ) ) : ?>
			<h2 class="wpb-ind-title"><?php echo esc_html( $section['heading'] ); ?></h2>
		<?php endif; ?>
		<?php if ( ! empty( $section['text'] ) ) : ?>
			<p class="wpb-ind-lede"><?php echo esc_html( $section['text'] ); ?></p>
		<?php endif; ?>
	</header>
	<?php
}

/**
 * A button from a config pair array( label, url ).
 *
 * @param array  $button Label and URL.
 * @param string $class  Button classes.
 */
function wpwisebones_industry_button( array $button, string $class = 'btn btn-primary' ) {
	if ( empty( $button[0] ) ) {
		return;
	}
	printf(
		'<a class="%1$s" href="%2$s">%3$s%4$s</a>',
		esc_attr( $class ),
		esc_url( wpwisebones_industry_url( isset( $button[1] ) ? (string) $button[1] : '' ) ),
		! empty( $button[2] ) ? '<i class="bi ' . esc_attr( $button[2] ) . ' me-2" aria-hidden="true"></i>' : '',
		esc_html( $button[0] )
	);
}

/* ── Wiring ─────────────────────────────────────────────────────────────── */

add_action( 'after_setup_theme', 'wpwisebones_industry_setup', 20 );

/**
 * Declare theme support for the kit and apply the config's Customizer defaults.
 */
function wpwisebones_industry_setup() {
	$config = wpwisebones_industry_config();
	if ( empty( $config ) ) {
		return;
	}

	// Registered here, not at load, so the parent and non-industry children
	// keep their search form and plain footer.
	add_action( 'wpwisebones_header_fallback', 'wpwisebones_industry_header_actions' );
	add_action( 'wpwisebones_footer_widgets_fallback', 'wpwisebones_industry_footer_columns' );

	add_theme_support(
		'wisebones-industry',
		array(
			'id'            => $config['id'],
			'family'        => $config['family'],
			'schema'        => $config['schema'],
			'content_types' => (array) $config['content_types'],
			'labels'        => (array) $config['labels'],
			'lead_type'     => $config['lead_type'],
		)
	);

	// Brand defaults. Each only fills an empty mod, so a colour the owner picks
	// in the Customizer always wins.
	$map = array(
		'primary'   => 'wpwisebones_color_primary',
		'secondary' => 'wpwisebones_color_secondary',
		'accent'    => 'wpwisebones_color_accent',
		'header_bg' => 'wpwisebones_color_header_bg',
		'footer_bg' => 'wpwisebones_color_footer_bg',
	);
	foreach ( $map as $key => $mod ) {
		if ( empty( $config['colors'][ $key ] ) ) {
			continue;
		}
		wpwisebones_industry_default_mod( $mod, (string) $config['colors'][ $key ] );
	}

	wpwisebones_industry_default_mod( 'wpwisebones_header_style', 'dark' === $config['header_style'] ? 'dark' : 'light' );

	// Hero copy from config, unless the owner has written their own.
	$hero = (array) $config['hero'];
	$pairs = array(
		'wpwisebones_hero_heading'    => isset( $hero['heading'] ) ? $hero['heading'] : '',
		'wpwisebones_hero_subheading' => isset( $hero['text'] ) ? $hero['text'] : '',
	);
	foreach ( $pairs as $mod => $default ) {
		if ( '' === $default ) {
			continue;
		}
		wpwisebones_industry_default_mod( $mod, $default );
	}
}

/**
 * Give a parent Customizer setting a new default.
 *
 * The parent passes its own default to get_theme_mod() (e.g. 'light' for the
 * header style), and WordPress filters that default when nothing is saved, so
 * an "only when empty" filter would never fire. This applies the industry
 * default whenever the owner has not saved a value of their own.
 *
 * @param string $mod     Theme mod name.
 * @param string $default New default.
 */
function wpwisebones_industry_default_mod( string $mod, string $default ) {
	add_filter(
		'theme_mod_' . $mod,
		static function ( $value ) use ( $mod, $default ) {
			$saved = get_theme_mods();
			return ( is_array( $saved ) && array_key_exists( $mod, $saved ) && '' !== $saved[ $mod ] ) ? $value : $default;
		}
	);
}

add_filter( 'body_class', 'wpwisebones_industry_body_class' );

/**
 * Body classes so a stylesheet can target a family or a single vertical.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function wpwisebones_industry_body_class( array $classes ): array {
	$config = wpwisebones_industry_config();
	if ( $config ) {
		$classes[] = 'wpb-industry';
		$classes[] = 'wpb-industry--' . sanitize_html_class( $config['family'] );
		$classes[] = 'wpb-industry--' . sanitize_html_class( $config['id'] );
	}
	return $classes;
}

/**
 * Register the industry stylesheet. Called from wpwisebones_enqueue_assets()
 * so it lands between the parent's CSS and the child's style.css.
 */
function wpwisebones_industry_enqueue() {
	if ( ! wpwisebones_is_industry() ) {
		return;
	}
	wp_enqueue_style( 'wpwisebones-industry', WPWISEBONES_URI . '/assets/css/industry.css', array( 'wpwisebones-main' ), WPWISEBONES_VERSION );

	$hero = wpwisebones_industry_section( 'hero' );
	if ( is_front_page() && isset( $hero['panel'] ) && 'calculator' === $hero['panel'] ) {
		wp_enqueue_script( 'wpwisebones-industry', WPWISEBONES_URI . '/assets/js/industry.js', array(), WPWISEBONES_VERSION, true );
	}
}

/* ── Header and footer fallbacks ────────────────────────────────────────── */

/**
 * Phone link and call-to-action button in the navbar, shown where the parent
 * would otherwise print a search form (i.e. when no header widgets are set).
 */
function wpwisebones_industry_header_actions() {
	$config = wpwisebones_industry_config();
	$cta    = (array) $config['header_cta'];
	$phone  = (string) get_theme_mod( 'wpwisebones_ind_phone', '' );
	?>
	<div class="wpb-ind-header-actions d-flex align-items-center gap-3 ms-lg-3">
		<?php if ( '' !== $phone ) : ?>
			<a class="wpb-ind-phone" href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><i class="bi bi-telephone" aria-hidden="true"></i> <?php echo esc_html( $phone ); ?></a>
		<?php endif; ?>
		<?php wpwisebones_industry_button( $cta, 'btn btn-primary btn-sm px-3' ); ?>
	</div>
	<?php
}

/**
 * A branded footer when the owner has not filled the footer widget areas.
 */
function wpwisebones_industry_footer_columns() {
	get_template_part( 'template-parts/industry/footer-columns', null, array( 'config' => wpwisebones_industry_config() ) );
}

/* ── Customizer ─────────────────────────────────────────────────────────── */

add_action( 'customize_register', 'wpwisebones_industry_customizer', 20 );

/**
 * "Front Page Sections" — section toggles, stats strip, phone and CTA copy.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function wpwisebones_industry_customizer( $wp_customize ) {
	$config = wpwisebones_industry_config();
	if ( empty( $config ) ) {
		return;
	}

	$wp_customize->add_section(
		'wpwisebones_industry',
		array(
			'title'       => __( 'Front Page Sections', 'wpwisebones' ),
			'description' => __( 'Switch front-page sections on or off and edit the short copy. Listings, projects, services, team and testimonials come from the WiseBones Industry Kit plugin.', 'wpwisebones' ),
			'panel'       => 'wpwisebones_panel',
			'priority'    => 5,
		)
	);

	$text = static function ( $id, $label, $default = '' ) use ( $wp_customize ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $default,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'wpwisebones_industry',
				'type'    => 'text',
			)
		);
	};

	$text( 'wpwisebones_ind_phone', __( 'Phone number (header and footer)', 'wpwisebones' ) );

	foreach ( $config['order'] as $name ) {
		$wp_customize->add_setting(
			'wpwisebones_ind_show_' . $name,
			array(
				'default'           => true,
				'sanitize_callback' => 'wp_validate_boolean',
			)
		);
		$wp_customize->add_control(
			'wpwisebones_ind_show_' . $name,
			array(
				/* translators: %s: section name, e.g. "testimonials". */
				'label'   => sprintf( __( 'Show the %s section', 'wpwisebones' ), str_replace( '-', ' ', $name ) ),
				'section' => 'wpwisebones_industry',
				'type'    => 'checkbox',
			)
		);
	}

	$wp_customize->add_setting(
		'wpwisebones_ind_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'wpwisebones_ind_hero_image',
			array(
				'label'       => __( 'Hero background photo', 'wpwisebones' ),
				'description' => __( 'Optional. A dark overlay keeps the headline readable.', 'wpwisebones' ),
				'section'     => 'wpwisebones_industry',
			)
		)
	);

	$hero = (array) $config['hero'];
	$text( 'wpwisebones_ind_eyebrow', __( 'Hero eyebrow', 'wpwisebones' ), isset( $hero['eyebrow'] ) ? (string) $hero['eyebrow'] : '' );

	$stats = array_values( (array) $config['stats'] );
	for ( $i = 1; $i <= 4; $i++ ) {
		$stat = isset( $stats[ $i - 1 ] ) ? (array) $stats[ $i - 1 ] : array( '', '' );
		/* translators: %d: stat number 1-4. */
		$text( 'wpwisebones_ind_stat_' . $i . '_value', sprintf( __( 'Stat %d — figure', 'wpwisebones' ), $i ), isset( $stat[0] ) ? (string) $stat[0] : '' );
		/* translators: %d: stat number 1-4. */
		$text( 'wpwisebones_ind_stat_' . $i . '_label', sprintf( __( 'Stat %d — label', 'wpwisebones' ), $i ), isset( $stat[1] ) ? (string) $stat[1] : '' );
	}

	$cta = wpwisebones_industry_section( 'cta' );
	$text( 'wpwisebones_ind_cta_heading', __( 'Closing call-to-action heading', 'wpwisebones' ), isset( $cta['heading'] ) ? (string) $cta['heading'] : '' );
	$text( 'wpwisebones_ind_cta_text', __( 'Closing call-to-action text', 'wpwisebones' ), isset( $cta['text'] ) ? (string) $cta['text'] : '' );
}

/**
 * The stats strip, from the Customizer with the config as default.
 *
 * @return array[] Pairs of figure and label.
 */
function wpwisebones_industry_stats(): array {
	$config = wpwisebones_industry_config();
	$stats  = array_values( (array) $config['stats'] );
	$out    = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$default = isset( $stats[ $i - 1 ] ) ? (array) $stats[ $i - 1 ] : array( '', '' );
		$value   = (string) get_theme_mod( 'wpwisebones_ind_stat_' . $i . '_value', isset( $default[0] ) ? $default[0] : '' );
		$label   = (string) get_theme_mod( 'wpwisebones_ind_stat_' . $i . '_label', isset( $default[1] ) ? $default[1] : '' );
		if ( '' !== $value || '' !== $label ) {
			$out[] = array( $value, $label );
		}
	}
	return $out;
}
