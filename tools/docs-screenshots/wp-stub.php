<?php
/**
 * Minimal WordPress API stub used only to render the themes and the shortcode
 * plugin to static HTML, so the documentation screenshots come from the real
 * template and shortcode code instead of hand-made mock-ups.
 *
 * This file is a documentation tool. It is never shipped in the theme or the
 * plugin and is not loaded by WordPress.
 *
 * @package WPWiseBones\Tools
 */

define( 'ABSPATH', __DIR__ . '/' );
define( 'WP_DEBUG', false );

global $shortcode_tags, $wp_stub;
$shortcode_tags = array();

$wp_stub = array(
	'template_dir'    => '',
	'template_uri'    => '',
	'stylesheet_dir'  => '',
	'stylesheet_uri'  => '',
	'theme_mods'      => array(),
	'options'         => array(),
	'styles'          => array(),
	'scripts'         => array(),
	'inline_styles'   => array(),
	'blogname'        => 'WPWiseBones',
	'blogdescription' => 'Bootstrap 5 starter theme for WordPress',
	'home'            => 'https://example.com',
	'posts'           => array(),
	'post_index'      => -1,
	'post'            => null,
	'menu'            => array(),
	'is_front_page'   => false,
	'is_home'         => false,
	'is_singular'     => false,
);

/* ── Base classes the theme subclasses ───────────────────────────────── */

class Walker_Nav_Menu {
	public $tree_type = 'menu';
	public $db_fields = array();
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

class WP_Widget {
	public $id_base;
	public $name;
	public function __construct( $id_base = '', $name = '', $widget_options = array(), $control_options = array() ) {
		$this->id_base = $id_base;
		$this->name    = $name;
	}
	public function widget( $args, $instance ) {}
	public function form( $instance ) {}
	public function update( $new, $old ) {
		return $new; }
	public function get_field_id( $f ) {
		return $this->id_base . '-' . $f; }
	public function get_field_name( $f ) {
		return $this->id_base . '[' . $f . ']'; }
}

class WP_Query {
	public $posts        = array();
	public $post_count   = 0;
	public $current_post = -1;
	public $post;
	public function __construct( $args = array() ) {
		global $wp_stub;
		$n           = isset( $args['posts_per_page'] ) ? (int) $args['posts_per_page'] : 3;
		$this->posts = array_slice( $wp_stub['posts'], 0, max( 1, $n ) );
		$this->post_count = count( $this->posts );
	}
	public function have_posts() {
		return $this->current_post + 1 < $this->post_count; }
	public function the_post() {
		global $wp_stub;
		++$this->current_post;
		$this->post      = $this->posts[ $this->current_post ];
		$wp_stub['post'] = $this->post;
	}
}

/* ── Escaping & sanitising ───────────────────────────────────────────── */

function esc_html( $t ) {
	return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8', false ); }
function esc_attr( $t ) {
	return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8', false ); }
function esc_textarea( $t ) {
	return esc_html( $t ); }
function esc_js( $t ) {
	return addslashes( (string) $t ); }
function esc_url( $u ) {
	return htmlspecialchars( (string) $u, ENT_QUOTES, 'UTF-8', false ); }
function esc_url_raw( $u ) {
	return (string) $u; }
function wp_kses_post( $c ) {
	return (string) $c; }
function wp_kses( $c, $allowed = array() ) {
	return (string) $c; }
function wp_strip_all_tags( $c ) {
	return wp_specialchars_decode( strip_tags( (string) $c ) ); }
function wp_specialchars_decode( $c ) {
	return html_entity_decode( (string) $c, ENT_QUOTES, 'UTF-8' ); }
function sanitize_html_class( $c ) {
	return preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $c ); }
function sanitize_key( $c ) {
	return preg_replace( '/[^a-z0-9_\-]/', '', strtolower( (string) $c ) ); }
function sanitize_text_field( $c ) {
	return trim( strip_tags( (string) $c ) ); }
function sanitize_title( $c ) {
	return preg_replace( '/[^a-z0-9]+/', '-', strtolower( (string) $c ) ); }
function sanitize_email( $c ) {
	return (string) $c; }
function absint( $n ) {
	return abs( (int) $n ); }
function wp_parse_args( $a, $d = array() ) {
	return array_merge( (array) $d, (array) $a ); }
function wp_trim_words( $text, $num = 55, $more = '&hellip;' ) {
	$words = preg_split( '/\s+/', wp_strip_all_tags( $text ) );
	return count( $words ) > $num ? implode( ' ', array_slice( $words, 0, $num ) ) . $more : implode( ' ', $words );
}
function wpautop( $t ) {
	return '<p>' . str_replace( "\n\n", '</p><p>', trim( (string) $t ) ) . '</p>'; }
function number_format_i18n( $n, $d = 0 ) {
	return number_format( (float) $n, $d ); }

/* ── i18n ────────────────────────────────────────────────────────────── */

function __( $t, $d = null ) {
	return $t; }
function _x( $t, $ctx = '', $d = null ) {
	return $t; }
function _n( $s, $p, $n, $d = null ) {
	return 1 === (int) $n ? $s : $p; }
function _nx( $s, $p, $n, $ctx = '', $d = null ) {
	return _n( $s, $p, $n ); }
function translate( $t, $d = null ) {
	return $t; }
function _e( $t, $d = null ) {
	echo $t; }
function esc_html__( $t, $d = null ) {
	return esc_html( $t ); }
function esc_attr__( $t, $d = null ) {
	return esc_attr( $t ); }
function esc_html_x( $t, $c = '', $d = null ) {
	return esc_html( $t ); }
function esc_html_e( $t, $d = null ) {
	echo esc_html( $t ); }
function esc_attr_e( $t, $d = null ) {
	echo esc_attr( $t ); }
function load_theme_textdomain( $d, $p = '' ) {
	return true; }
function load_plugin_textdomain( $d, $x = false, $p = '' ) {
	return true; }

/* ── Hooks ───────────────────────────────────────────────────────────── */

global $wp_stub_actions, $wp_stub_filters;
$wp_stub_actions = array();
$wp_stub_filters = array();

function add_action( $tag, $cb, $priority = 10, $args = 1 ) {
	global $wp_stub_actions;
	$wp_stub_actions[ $tag ][ $priority ][] = $cb;
	return true;
}
function do_action( $tag, ...$args ) {
	global $wp_stub_actions;
	if ( empty( $wp_stub_actions[ $tag ] ) ) {
		return;
	}
	ksort( $wp_stub_actions[ $tag ] );
	foreach ( $wp_stub_actions[ $tag ] as $cbs ) {
		foreach ( $cbs as $cb ) {
			if ( is_callable( $cb ) ) {
				call_user_func_array( $cb, $args );
			}
		}
	}
}
function add_filter( $tag, $cb, $priority = 10, $args = 1 ) {
	global $wp_stub_filters;
	$wp_stub_filters[ $tag ][ $priority ][] = array( $cb, $args );
	return true;
}
function apply_filters( $tag, $value, ...$args ) {
	global $wp_stub_filters;
	if ( empty( $wp_stub_filters[ $tag ] ) ) {
		return $value;
	}
	ksort( $wp_stub_filters[ $tag ] );
	foreach ( $wp_stub_filters[ $tag ] as $cbs ) {
		foreach ( $cbs as $entry ) {
			list( $cb, $accepted ) = $entry;
			if ( is_callable( $cb ) ) {
				$value = call_user_func_array( $cb, array_merge( array( $value ), array_slice( $args, 0, max( 0, $accepted - 1 ) ) ) );
			}
		}
	}
	return $value;
}
function remove_action( $tag, $cb, $priority = 10 ) {
	return true; }
function remove_filter( $tag, $cb, $priority = 10 ) {
	return true; }
function has_action( $tag, $cb = false ) {
	global $wp_stub_actions;
	return ! empty( $wp_stub_actions[ $tag ] ); }
function has_filter( $tag, $cb = false ) {
	return false; }
function did_action( $tag ) {
	return 1; }
function doing_action( $tag = null ) {
	return false; }
function current_filter() {
	return ''; }
function register_activation_hook( $f, $cb ) {}
function register_deactivation_hook( $f, $cb ) {}

/* ── Shortcode API (ported from wp-includes/shortcodes.php) ──────────── */

function add_shortcode( $tag, $cb ) {
	global $shortcode_tags;
	$shortcode_tags[ $tag ] = $cb;
}
function remove_shortcode( $tag ) {
	global $shortcode_tags;
	unset( $shortcode_tags[ $tag ] );
}
function shortcode_exists( $tag ) {
	global $shortcode_tags;
	return array_key_exists( $tag, $shortcode_tags );
}
function get_shortcode_regex( $tagnames = null ) {
	global $shortcode_tags;
	$tagnames  = $tagnames ? $tagnames : array_keys( $shortcode_tags );
	$tagregexp = implode( '|', array_map( 'preg_quote', $tagnames ) );
	return '\\['
		. '(\\[?)'
		. "($tagregexp)"
		. '(?![\\w-])'
		. '('
		. '[^\\]\\/]*'
		. '(?:'
		. '\\/(?!\\])'
		. '[^\\]\\/]*'
		. ')*?'
		. ')'
		. '(?:'
		. '(\\/)'
		. '\\]'
		. '|'
		. '\\]'
		. '(?:'
		. '('
		. '[^\\[]*+'
		. '(?:'
		. '\\[(?!\\/\\2\\])'
		. '[^\\[]*+'
		. ')*+'
		. ')'
		. '\\[\\/\\2\\]'
		. ')?'
		. ')'
		. '(\\]?)';
}
function do_shortcode( $content, $ignore_html = false ) {
	global $shortcode_tags;
	if ( null === $content || false === strpos( $content, '[' ) || empty( $shortcode_tags ) ) {
		return (string) $content;
	}
	$pattern = get_shortcode_regex();
	return preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $content );
}
function do_shortcode_tag( $m ) {
	global $shortcode_tags;
	if ( '[' === $m[1] && ']' === $m[6] ) {
		return substr( $m[0], 1, -1 );
	}
	$tag  = $m[2];
	$attr = shortcode_parse_atts( $m[3] );
	if ( ! isset( $shortcode_tags[ $tag ] ) || ! is_callable( $shortcode_tags[ $tag ] ) ) {
		return $m[0];
	}
	$content = isset( $m[5] ) ? $m[5] : null;
	return $m[1] . call_user_func( $shortcode_tags[ $tag ], (array) $attr, $content, $tag ) . $m[6];
}
function shortcode_parse_atts( $text ) {
	$atts    = array();
	$pattern = '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
	$text    = preg_replace( "/[\x{00a0}\x{200b}]+/u", ' ', $text );
	if ( preg_match_all( $pattern, $text, $match, PREG_SET_ORDER ) ) {
		foreach ( $match as $m ) {
			if ( ! empty( $m[1] ) ) {
				$atts[ strtolower( $m[1] ) ] = stripcslashes( $m[2] );
			} elseif ( ! empty( $m[3] ) ) {
				$atts[ strtolower( $m[3] ) ] = stripcslashes( $m[4] );
			} elseif ( ! empty( $m[5] ) ) {
				$atts[ strtolower( $m[5] ) ] = stripcslashes( $m[6] );
			} elseif ( isset( $m[7] ) && strlen( $m[7] ) ) {
				$atts[] = stripcslashes( $m[7] );
			} elseif ( isset( $m[8] ) && strlen( $m[8] ) ) {
				$atts[] = stripcslashes( $m[8] );
			} elseif ( isset( $m[9] ) ) {
				$atts[] = stripcslashes( $m[9] );
			}
		}
		foreach ( $atts as $k => $v ) {
			if ( false !== strpos( $v, '<' ) ) {
				$atts[ $k ] = $v;
			}
		}
	} else {
		$atts = ltrim( $text );
	}
	return $atts;
}
function shortcode_atts( $pairs, $atts, $shortcode = '' ) {
	$atts = (array) $atts;
	$out  = array();
	foreach ( $pairs as $name => $default ) {
		$out[ $name ] = array_key_exists( $name, $atts ) ? $atts[ $name ] : $default;
	}
	return $out;
}

/* ── Theme paths & options ───────────────────────────────────────────── */

function wp_stub_set( $key, $value ) {
	global $wp_stub;
	$wp_stub[ $key ] = $value;
}
function get_template_directory() {
	global $wp_stub;
	return $wp_stub['template_dir']; }
function get_template_directory_uri() {
	global $wp_stub;
	return $wp_stub['template_uri']; }
function get_stylesheet_directory() {
	global $wp_stub;
	return $wp_stub['stylesheet_dir']; }
function get_stylesheet_directory_uri() {
	global $wp_stub;
	return $wp_stub['stylesheet_uri']; }
function get_stylesheet_uri() {
	global $wp_stub;
	return $wp_stub['stylesheet_uri'] . '/style.css'; }
function get_parent_theme_file_path( $f = '' ) {
	return get_template_directory() . '/' . ltrim( $f, '/' ); }
function get_theme_file_uri( $f = '' ) {
	return get_stylesheet_directory_uri() . '/' . ltrim( $f, '/' ); }
function get_theme_mod( $name, $default = false ) {
	global $wp_stub;
	$value = array_key_exists( $name, $wp_stub['theme_mods'] ) ? $wp_stub['theme_mods'][ $name ] : $default;
	// WordPress runs theme_mod_{$name} over the value, which is how child themes
	// such as Antivig set the parent's header style without a saved setting.
	return apply_filters( 'theme_mod_' . $name, $value );
}
function set_theme_mod( $name, $value ) {
	global $wp_stub;
	$wp_stub['theme_mods'][ $name ] = $value; }
function get_option( $name, $default = false ) {
	global $wp_stub;
	return array_key_exists( $name, $wp_stub['options'] ) ? $wp_stub['options'][ $name ] : $default;
}
function update_option( $name, $value, $autoload = null ) {
	global $wp_stub;
	$wp_stub['options'][ $name ] = $value;
	return true; }
function add_option( $n, $v = '' ) {
	return update_option( $n, $v ); }
function delete_option( $n ) {
	return true; }
function home_url( $path = '', $scheme = null ) {
	global $wp_stub;
	return rtrim( $wp_stub['home'], '/' ) . '/' . ltrim( (string) $path, '/' ); }
function site_url( $path = '', $scheme = null ) {
	return home_url( $path ); }
function admin_url( $path = '', $scheme = 'admin' ) {
	return home_url( 'wp-admin/' . ltrim( (string) $path, '/' ) ); }
function includes_url( $p = '' ) {
	return home_url( 'wp-includes/' . ltrim( (string) $p, '/' ) ); }
function get_bloginfo( $show = '', $filter = 'raw' ) {
	global $wp_stub;
	switch ( $show ) {
		case 'name':
			return $wp_stub['blogname'];
		case 'description':
			return $wp_stub['blogdescription'];
		case 'charset':
			return 'UTF-8';
		case 'url':
		case 'wpurl':
			return home_url();
		case 'language':
			return 'en-US';
		case 'version':
			return '6.6';
		default:
			return '';
	}
}
function bloginfo( $show = '' ) {
	echo esc_html( get_bloginfo( $show ) ); }
function language_attributes() {
	echo 'lang="en-US"'; }
function get_locale() {
	return 'en_US'; }
function wp_get_theme( $slug = null ) {
	return new class() {
		public function get( $k ) {
			global $wp_stub;
			if ( 'Version' === $k ) {
				return isset( $wp_stub['theme_version'] ) ? $wp_stub['theme_version'] : '1.0.0';
			}
			return isset( $wp_stub['theme_name'] ) ? $wp_stub['theme_name'] : 'WPWiseBones';
		}
		public function get_stylesheet() {
			global $wp_stub;
			return basename( $wp_stub['stylesheet_dir'] ); }
		public function exists() {
			return true; }
		public function __toString() {
			return $this->get( 'Name' ); }
	};
}
function is_child_theme() {
	global $wp_stub;
	return $wp_stub['stylesheet_dir'] !== $wp_stub['template_dir'];
}
function wp_get_environment_type() {
	return 'production'; }
function current_time( $type = 'timestamp', $gmt = 0 ) {
	return time(); }
function date_i18n( $format, $ts = null ) {
	return gmdate( $format, $ts ? $ts : time() ); }
function wp_date( $format, $ts = null ) {
	return gmdate( $format, $ts ? $ts : time() ); }
function wp_rand( $min = 0, $max = 0 ) {
	return random_int( $min, $max ? $max : PHP_INT_MAX ); }
function wp_generate_password( $len = 12 ) {
	return substr( md5( (string) wp_rand() ), 0, $len ); }
function wp_create_nonce( $a = -1 ) {
	return 'stub-nonce'; }
function wp_nonce_field( ...$a ) {
	echo '<input type="hidden" name="_wpnonce" value="stub-nonce">'; }
function wp_verify_nonce( ...$a ) {
	return 1; }
function check_admin_referer( ...$a ) {
	return 1; }
function is_admin() {
	return false; }
function is_user_logged_in() {
	return false; }
function current_user_can( $c ) {
	return false; }
function is_customize_preview() {
	return false; }
function is_wp_error( $t ) {
	return false; }
function wp_doing_ajax() {
	return false; }
function get_search_query() {
	return ''; }
function paginate_links( $args = array() ) {
	return ''; }
function get_avatar( $id, $size = 96, $d = '', $alt = '' ) {
	return '<span class="avatar rounded-circle bg-secondary d-inline-block" style="width:' . (int) $size . 'px;height:' . (int) $size . 'px"></span>'; }

/* ── Enqueue / head / footer ─────────────────────────────────────────── */

function wp_register_style( $h, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
	global $wp_stub;
	$wp_stub['styles'][ $h ] = $src;
}
function wp_enqueue_style( $h, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
	global $wp_stub;
	if ( $src || ! isset( $wp_stub['styles'][ $h ] ) ) {
		$wp_stub['styles'][ $h ] = $src;
	}
}
function wp_register_script( $h, $src = '', $deps = array(), $ver = false, $footer = false ) {
	global $wp_stub;
	$wp_stub['scripts'][ $h ] = $src;
}
function wp_enqueue_script( $h, $src = '', $deps = array(), $ver = false, $footer = false ) {
	global $wp_stub;
	if ( $src || ! isset( $wp_stub['scripts'][ $h ] ) ) {
		$wp_stub['scripts'][ $h ] = $src;
	}
}
function wp_add_inline_style( $h, $css ) {
	global $wp_stub;
	$wp_stub['inline_styles'][] = $css;
	return true;
}
function wp_add_inline_script( $h, $js, $pos = 'after' ) {
	return true; }
function wp_localize_script( $h, $obj, $data ) {
	return true; }
function wp_script_add_data( $h, $k, $v ) {
	return true; }
function wp_style_add_data( $h, $k, $v ) {
	return true; }
function wp_dequeue_style( $h ) {
	global $wp_stub;
	unset( $wp_stub['styles'][ $h ] ); }
function wp_dequeue_script( $h ) {
	global $wp_stub;
	unset( $wp_stub['scripts'][ $h ] ); }
function wp_deregister_script( $h ) {
	wp_dequeue_script( $h ); }
function wp_style_is( $h, $list = 'enqueued' ) {
	global $wp_stub;
	return isset( $wp_stub['styles'][ $h ] ); }
function wp_script_is( $h, $list = 'enqueued' ) {
	global $wp_stub;
	return isset( $wp_stub['scripts'][ $h ] ); }
function add_editor_style( $s ) {}
function add_theme_support( ...$a ) {}
function current_theme_supports( ...$a ) {
	return true; }
function add_image_size( ...$a ) {}
function set_post_thumbnail_size( ...$a ) {}
function register_nav_menus( $m ) {}
function register_nav_menu( $l, $d ) {}
function has_nav_menu( $l ) {
	return true; }
function register_sidebar( $a ) {}
function is_active_sidebar( $i ) {
	return false; }
function dynamic_sidebar( $i ) {
	return false; }
function register_widget( $w ) {}
function register_block_style( ...$a ) {}
function register_block_pattern( ...$a ) {}
function register_block_pattern_category( ...$a ) {}
function wp_enqueue_media() {}
function wp_oembed_get( $u, $a = array() ) {
	return ''; }
function get_theme_file_path( $f = '' ) {
	return get_stylesheet_directory() . '/' . ltrim( $f, '/' ); }

function wp_head() {
	global $wp_stub;
	do_action( 'wp_enqueue_scripts' );
	do_action( 'wp_head' );
	foreach ( $wp_stub['styles'] as $handle => $src ) {
		if ( ! $src ) {
			continue;
		}
		echo "\n<link rel=\"stylesheet\" id=\"" . esc_attr( $handle ) . "-css\" href=\"" . esc_url( $src ) . "\">";
	}
	if ( $wp_stub['inline_styles'] ) {
		echo "\n<style>" . implode( "\n", $wp_stub['inline_styles'] ) . '</style>';
	}
}
function wp_footer() {
	global $wp_stub;
	do_action( 'wp_footer' );
	foreach ( $wp_stub['scripts'] as $handle => $src ) {
		if ( ! $src ) {
			continue;
		}
		echo "\n<script src=\"" . esc_url( $src ) . "\"></script>";
	}
}
function wp_body_open() {
	do_action( 'wp_body_open' ); }
function body_class( $class = '' ) {
	$classes = apply_filters( 'body_class', array( 'wpb-body', 'no-sidebar' ) );
	echo 'class="' . esc_attr( implode( ' ', array_unique( (array) $classes ) ) ) . '"';
}
function post_class( $class = '' ) {
	echo 'class="' . esc_attr( 'post type-post ' . ( is_string( $class ) ? $class : implode( ' ', (array) $class ) ) ) . '"'; }
function get_post_class( $class = '' ) {
	return array( 'post', 'type-post' ); }

/* ── Template loading ────────────────────────────────────────────────── */

function locate_template( $names, $load = false, $once = true, $args = array() ) {
	foreach ( (array) $names as $name ) {
		foreach ( array( get_stylesheet_directory(), get_template_directory() ) as $dir ) {
			if ( $name && file_exists( $dir . '/' . $name ) ) {
				return $dir . '/' . $name;
			}
		}
	}
	return '';
}
function get_template_part( $slug, $name = null, $args = array() ) {
	$templates = array();
	if ( $name ) {
		$templates[] = "{$slug}-{$name}.php";
	}
	$templates[] = "{$slug}.php";
	$located     = locate_template( $templates );
	if ( $located ) {
		include $located;
	}
}
function get_header( $name = null ) {
	$located = locate_template( $name ? array( "header-{$name}.php", 'header.php' ) : array( 'header.php' ) );
	if ( $located ) {
		include $located;
	}
}
function get_footer( $name = null ) {
	$located = locate_template( $name ? array( "footer-{$name}.php", 'footer.php' ) : array( 'footer.php' ) );
	if ( $located ) {
		include $located;
	}
}
function get_sidebar( $name = null ) {
	$located = locate_template( $name ? array( "sidebar-{$name}.php", 'sidebar.php' ) : array( 'sidebar.php' ) );
	if ( $located ) {
		include $located;
	}
}
function get_search_form( $args = array() ) {
	$located = locate_template( array( 'searchform.php' ) );
	if ( $located ) {
		include $located;
	}
}
function comments_template( $file = '/comments.php', $separate = false ) {}
function wp_link_pages( $args = array() ) {}

/* ── Conditionals & the loop ─────────────────────────────────────────── */

function is_front_page() {
	global $wp_stub;
	return (bool) $wp_stub['is_front_page']; }
function is_home() {
	global $wp_stub;
	return (bool) $wp_stub['is_home']; }
function is_singular( $t = '' ) {
	global $wp_stub;
	return (bool) $wp_stub['is_singular']; }
function is_single( $p = '' ) {
	return is_singular(); }
function is_page( $p = '' ) {
	return is_singular(); }
function is_archive() {
	return false; }
function is_category() {
	return false; }
function is_tag() {
	return false; }
function is_author() {
	return false; }
function is_search() {
	return false; }
function is_404() {
	return false; }
function is_attachment() {
	return false; }
function is_paged() {
	return false; }
function is_sticky( $id = 0 ) {
	return false; }
function is_active_widget( ...$a ) {
	return false; }
function comments_open( $id = null ) {
	return false; }
function pings_open( $id = null ) {
	return false; }
function post_password_required( $p = null ) {
	return false; }
function display_header_text() {
	return true; }
function has_custom_logo( $id = 0 ) {
	return false; }
function the_custom_logo( $id = 0 ) {}
function has_post_thumbnail( $p = null ) {
	global $wp_stub;
	return ! empty( $wp_stub['post']['thumb'] ); }

function have_posts() {
	global $wp_stub;
	return $wp_stub['post_index'] + 1 < count( $wp_stub['posts'] );
}
function the_post() {
	global $wp_stub;
	++$wp_stub['post_index'];
	$wp_stub['post'] = $wp_stub['posts'][ $wp_stub['post_index'] ];
}
function rewind_posts() {
	global $wp_stub;
	$wp_stub['post_index'] = -1; }
function wp_reset_postdata() {
	global $wp_stub;
	$wp_stub['post'] = isset( $wp_stub['posts'][ $wp_stub['post_index'] ] ) ? $wp_stub['posts'][ $wp_stub['post_index'] ] : null; }
function wp_reset_query() {
	wp_reset_postdata(); }
function wp_stub_field( $key, $default = '' ) {
	global $wp_stub;
	return isset( $wp_stub['post'][ $key ] ) ? $wp_stub['post'][ $key ] : $default;
}
function get_the_ID() {
	return (int) wp_stub_field( 'id', 1 ); }
function get_the_title( $p = 0 ) {
	return wp_stub_field( 'title', 'Sample post' ); }
function the_title( $before = '', $after = '', $echo = true ) {
	$t = $before . get_the_title() . $after;
	if ( $echo ) {
		echo $t;
	}
	return $t;
}
function single_post_title( $prefix = '', $display = true ) {
	$t = $prefix . 'Blog';
	if ( $display ) {
		echo esc_html( $t );
	}
	return $t;
}
function get_permalink( $p = 0 ) {
	return home_url( '/' . wp_stub_field( 'slug', 'sample-post' ) . '/' ); }
function the_permalink() {
	echo esc_url( get_permalink() ); }
function get_the_excerpt( $p = null ) {
	return wp_stub_field( 'excerpt', '' ); }
function the_excerpt() {
	echo '<p>' . esc_html( get_the_excerpt() ) . '</p>'; }
function the_content( $more = null ) {
	echo wp_stub_field( 'content', '' ); }
function get_the_content( $more = null ) {
	return wp_stub_field( 'content', '' ); }
function get_the_date( $format = '', $p = null ) {
	return wp_stub_field( 'date', 'March 4, 2025' ); }
function the_date( $f = '', $b = '', $a = '', $echo = true ) {
	echo esc_html( get_the_date() ); }
function get_the_time( $f = '', $p = null ) {
	return '09:00'; }
function get_the_modified_date( $f = '', $p = null ) {
	return get_the_date(); }
function get_the_author() {
	return wp_stub_field( 'author', 'Jane Realtor' ); }
function the_author() {
	echo esc_html( get_the_author() ); }
function get_the_author_meta( $f = '', $id = false ) {
	return get_the_author(); }
function get_author_posts_url( $id, $nice = '' ) {
	return home_url( '/author/jane/' ); }
function get_the_date_iso() {
	return '2025-03-04'; }
function get_post_type( $p = null ) {
	return 'post'; }
function get_post_meta( $id, $key = '', $single = false ) {
	return $single ? '' : array(); }
function get_post_field( $f, $p = null ) {
	return wp_stub_field( $f, '' ); }
function get_post( $p = null ) {
	global $wp_stub;
	return (object) (array) $wp_stub['post']; }
function get_the_post_thumbnail( $p = null, $size = 'post-thumbnail', $attr = array() ) {
	$src = wp_stub_field( 'thumb', '' );
	if ( ! $src ) {
		return '';
	}
	$class = isset( $attr['class'] ) ? $attr['class'] : '';
	return '<img src="' . esc_url( $src ) . '" alt="" class="' . esc_attr( $class ) . '" loading="lazy">';
}
function the_post_thumbnail( $size = 'post-thumbnail', $attr = array() ) {
	echo get_the_post_thumbnail( null, $size, $attr ); }
function get_the_post_thumbnail_url( $p = null, $size = '' ) {
	return wp_stub_field( 'thumb', '' ); }
function get_the_category_list( $sep = '', $parents = '', $id = false ) {
	return '<a href="#" rel="category tag">Guides</a>'; }
function get_the_category( $id = false ) {
	return array( (object) array( 'name' => 'Guides', 'term_id' => 1, 'slug' => 'guides' ) ); }
function get_the_tag_list( $b = '', $s = '', $a = '', $id = 0 ) {
	return '<a href="#" rel="tag">bootstrap</a>'; }
function get_the_terms( $p, $tax ) {
	return array(); }
function get_category_link( $c ) {
	return home_url( '/category/guides/' ); }
function get_term_link( $t, $tax = '' ) {
	return home_url( '/category/guides/' ); }
function get_comments_number( $p = 0 ) {
	return 0; }
function comments_number( $z = '', $o = '', $m = '' ) {
	echo esc_html( $z ); }
function get_comments_link( $p = 0 ) {
	return get_permalink() . '#comments'; }
function get_next_posts_link( ...$a ) {
	return ''; }
function get_previous_posts_link( ...$a ) {
	return ''; }
function get_edit_post_link( $p = 0 ) {
	return ''; }
function edit_post_link( ...$a ) {}

/* ── Navigation ──────────────────────────────────────────────────────── */

function wp_nav_menu( $args = array() ) {
	global $wp_stub;
	$items = $wp_stub['menu'];
	if ( ! $items ) {
		return '';
	}
	$depth_class = isset( $args['menu_class'] ) ? $args['menu_class'] : 'navbar-nav';
	$html        = '<ul class="' . esc_attr( $depth_class ) . '">';
	foreach ( $items as $i => $item ) {
		$active = 0 === $i ? ' active' : '';
		$html  .= '<li class="nav-item"><a class="nav-link' . $active . '" href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a></li>';
	}
	$html .= '</ul>';
	if ( ! empty( $args['echo'] ) || ! isset( $args['echo'] ) ) {
		echo $html;
		return null;
	}
	return $html;
}
function wp_page_menu( $args = array() ) {
	wp_nav_menu( $args ); }
function wp_list_pages( $args = array() ) {
	return ''; }
function wp_get_nav_menu_items( $m, $a = array() ) {
	return array(); }
function wp_get_nav_menu_object( $m ) {
	return false; }
function get_nav_menu_locations() {
	return array(); }

/* ── Plugin / admin surface (registered but never rendered here) ─────── */

function plugin_dir_path( $file ) {
	return rtrim( dirname( $file ), '/' ) . '/'; }
function plugin_dir_url( $file ) {
	global $wp_stub;
	return isset( $wp_stub['plugin_uri'] ) ? $wp_stub['plugin_uri'] : ''; }
function plugin_basename( $file ) {
	return basename( dirname( $file ) ) . '/' . basename( $file ); }
function plugins_url( $path = '', $plugin = '' ) {
	return plugin_dir_url( $plugin ) . ltrim( $path, '/' ); }
function is_plugin_active( $p ) {
	return true; }
function get_plugins() {
	return array(); }
function add_menu_page( ...$a ) {
	return ''; }
function add_submenu_page( ...$a ) {
	return ''; }
function add_theme_page( ...$a ) {
	return ''; }
function add_options_page( ...$a ) {
	return ''; }
function add_management_page( ...$a ) {
	return ''; }
function add_meta_box( ...$a ) {}
function remove_meta_box( ...$a ) {}
function register_setting( ...$a ) {}
function add_settings_section( ...$a ) {}
function add_settings_field( ...$a ) {}
function settings_fields( $g ) {}
function do_settings_sections( $p ) {}
function submit_button( ...$a ) {}
function checked( $a, $b = true, $echo = true ) {
	return ''; }
function selected( $a, $b = true, $echo = true ) {
	return ''; }
function disabled( $a, $b = true, $echo = true ) {
	return ''; }
function wp_add_dashboard_widget( ...$a ) {}
function wp_die( $m = '', $t = '', $a = array() ) {
	throw new RuntimeException( is_string( $m ) ? $m : 'wp_die' ); }
function wp_send_json_success( $d = null ) {}
function wp_send_json_error( $d = null ) {}
function wp_safe_redirect( $l, $s = 302 ) {}
function wp_redirect( $l, $s = 302 ) {}
function wp_nonce_url( $u, $a = -1, $n = '_wpnonce' ) {
	return $u; }
function wp_upload_dir( $t = null, $c = true ) {
	return array(
		'basedir' => sys_get_temp_dir(),
		'baseurl' => home_url( '/wp-content/uploads' ),
		'path'    => sys_get_temp_dir(),
		'url'     => home_url( '/wp-content/uploads' ),
		'error'   => false,
	); }
function wp_mkdir_p( $d ) {
	return true; }
function wp_get_attachment_image( $id, $size = 'thumbnail', $icon = false, $attr = '' ) {
	return ''; }
function wp_get_attachment_url( $id ) {
	return ''; }
function wp_get_attachment_image_url( $id, $size = 'thumbnail' ) {
	return ''; }
function get_posts( $args = array() ) {
	return array(); }
function get_page_by_path( $p, $o = OBJECT, $t = 'page' ) {
	return null; }
function wp_insert_post( $p, $e = false ) {
	return 0; }
function get_pages( $a = array() ) {
	return array(); }
function get_current_screen() {
	return null; }
function screen_icon() {}
function _doing_it_wrong( ...$a ) {}
function esc_sql( $s ) {
	return $s; }
function wp_unslash( $v ) {
	return is_string( $v ) ? stripslashes( $v ) : $v; }
function wp_slash( $v ) {
	return $v; }
function wp_json_encode( $d, $o = 0, $depth = 512 ) {
	return json_encode( $d, $o, $depth ); }
function wp_remote_get( $u, $a = array() ) {
	return array(); }
function wp_remote_retrieve_body( $r ) {
	return ''; }
function get_transient( $k ) {
	return false; }
function set_transient( $k, $v, $e = 0 ) {
	return true; }
function delete_transient( $k ) {
	return true; }
function wp_cache_get( $k, $g = '' ) {
	return false; }
function wp_cache_set( $k, $v, $g = '', $e = 0 ) {
	return true; }
function wp_schedule_event( ...$a ) {
	return false; }
function wp_next_scheduled( ...$a ) {
	return false; }
function wp_clear_scheduled_hook( ...$a ) {}
function get_num_queries() {
	return 0; }
function timer_stop( $d = 0, $p = 3 ) {
	return '0.05'; }

/* ── Colour & misc helpers used by the Customizer output ─────────────── */

function sanitize_hex_color( $color ) {
	if ( '' === $color || null === $color ) {
		return '';
	}
	return preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', (string) $color ) ? $color : '';
}
function sanitize_hex_color_no_hash( $color ) {
	return ltrim( (string) sanitize_hex_color( '#' . ltrim( (string) $color, '#' ) ), '#' ); }
function maybe_hash_hex_color( $color ) {
	$c = sanitize_hex_color_no_hash( $color );
	return $c ? '#' . $c : ''; }
function get_theme_support( $f, ...$a ) {
	return true; }
function is_rtl() {
	return false; }

/* ── SEO / query helpers ─────────────────────────────────────────────── */

function get_site_icon_url( $size = 512, $url = '', $blog_id = 0 ) {
	return ''; }
function has_site_icon( $blog_id = 0 ) {
	return false; }
function wp_get_document_title() {
	return get_bloginfo( 'name' ); }
function wp_title( $sep = '', $display = true, $seplocation = '' ) {
	return ''; }
function get_queried_object() {
	return null; }
function get_queried_object_id() {
	return 0; }
function get_the_archive_title() {
	return 'Archive'; }
function get_the_archive_description() {
	return ''; }
function the_archive_title( $b = '', $a = '' ) {
	echo $b . esc_html( get_the_archive_title() ) . $a; }
function the_archive_description( $b = '', $a = '' ) {}
function term_description( $t = 0, $tax = '' ) {
	return ''; }
function get_year_link( $y ) {
	return home_url( '/2025/' ); }
function get_month_link( $y, $m ) {
	return home_url( '/2025/03/' ); }
function get_day_link( $y, $m, $d ) {
	return home_url( '/2025/03/04/' ); }
function get_the_author_posts_link() {
	return '<a href="' . esc_url( get_author_posts_url( 0 ) ) . '">' . esc_html( get_the_author() ) . '</a>'; }
function get_the_author_link() {
	return get_the_author_posts_link(); }
function is_multi_author() {
	return false; }
function wp_get_current_user() {
	return (object) array( 'display_name' => 'Jane Realtor', 'ID' => 1 ); }
function get_userdata( $id ) {
	return wp_get_current_user(); }
function get_current_blog_id() {
	return 1; }
function get_search_link( $q = '' ) {
	return home_url( '/?s=' . rawurlencode( $q ) ); }
function get_post_type_archive_link( $t ) {
	return home_url( '/blog/' ); }
function wp_get_shortlink( $id = 0, $ctx = 'post' ) {
	return get_permalink(); }
function get_post_time( $f = 'U', $gmt = false, $p = null ) {
	return time(); }
function get_post_modified_time( $f = 'U', $gmt = false, $p = null ) {
	return time(); }
function get_the_modified_time( $f = '', $p = null ) {
	return '09:00'; }
function mysql2date( $f, $d, $t = true ) {
	return gmdate( $f, strtotime( (string) $d ) ); }
function get_post_thumbnail_id( $p = null ) {
	return 0; }
function wp_get_attachment_image_src( $id, $size = 'thumbnail', $icon = false ) {
	return array( '', 0, 0, false ); }
function get_the_content_feed( $t = 'rss2' ) {
	return ''; }
function is_feed() {
	return false; }
function is_preview() {
	return false; }
function is_tax( $t = '', $term = '' ) {
	return false; }
function is_post_type_archive( $t = '' ) {
	return false; }
function is_year() {
	return false; }
function is_month() {
	return false; }
function is_day() {
	return false; }
function get_query_var( $v, $default = '' ) {
	return $default; }
function have_comments() {
	return false; }
function wp_list_comments( $a = array(), $c = null ) {}
function comment_form( $a = array(), $p = null ) {}
function get_post_type_object( $t ) {
	return (object) array( 'labels' => (object) array( 'name' => 'Posts' ) ); }

function the_ID() {
	echo (int) get_the_ID(); }
function the_title_attribute( $args = '' ) {
	echo esc_attr( get_the_title() ); }
function the_category( $sep = '', $parents = '', $id = false ) {
	echo get_the_category_list( $sep ); }
function the_tags( $b = '', $s = '', $a = '' ) {
	echo $b . get_the_tag_list() . $a; }
function the_author_posts_link() {
	echo get_the_author_posts_link(); }
function the_widget( $w, $i = array(), $a = array() ) {}
function get_template_directory_uri_stub() {
	return get_template_directory_uri(); }

/* ── Not exercised by the rendered pages, present so includes resolve ── */

function post_type_exists( $t ) {
	return false; }
function get_users( $args = array() ) {
	return array(); }
function wc_get_product( $p = false ) {
	return null; }
function wc_get_template_part( $slug, $name = '' ) {}
function add_query_arg( ...$args ) {
	$url = end( $args );
	return is_string( $url ) ? $url : home_url();
}

/* The main query object the theme's pagination helper reads. */
$GLOBALS['wp_query'] = new class() {
	public $max_num_pages = 1;
	public $found_posts   = 3;
	public $post_count    = 3;
};

/* ── Used by the Antivig child theme ─────────────────────────────────── */

function wp_make_link_relative( $link ) {
	return preg_replace( '|^(https?:)?//[^/]+(/.*)|i', '$2', (string) $link ); }
function get_site_url( $blog_id = null, $path = '', $scheme = null ) {
	return home_url( $path ); }
function get_home_url( $blog_id = null, $path = '', $scheme = null ) {
	return home_url( $path ); }
function wp_get_theme_file_uri( $file = '' ) {
	return get_theme_file_uri( $file ); }
function is_ssl() {
	return true; }
function get_the_permalink( $p = 0 ) {
	return get_permalink( $p ); }
function get_locale_stub() {
	return get_locale(); }

function get_theme_mods() {
	global $wp_stub;
	return $wp_stub['theme_mods']; }
