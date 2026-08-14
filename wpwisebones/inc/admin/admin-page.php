<?php
/**
 * Theme Options admin page (Appearance â†’ Theme Options).
 *
 * Registered as a sub-page under Appearance via add_theme_page().
 * Capability: edit_theme_options (matches Customizer; per WP.org Required Â§4).
 * Storage:    single array option `wpwisebones_options` (WP.org Required Â§4).
 * Scripts:    scoped to this page's hook suffix only (WP.org Required Â§4).
 */

defined( 'ABSPATH' ) || exit;

/* â”€â”€ Register menu page â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'admin_menu', 'wpwisebones_add_admin_menu' );

function wpwisebones_add_admin_menu() {
	add_theme_page(
		__( 'WPWiseBones Options', 'wpwisebones' ),
		__( 'Theme Options', 'wpwisebones' ),
		'edit_theme_options',
		'wpwisebones-theme-options',
		'wpwisebones_admin_options_page'
	);
}

/* â”€â”€ Settings API registration â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'admin_init', 'wpwisebones_admin_settings_init' );

function wpwisebones_admin_settings_init() {
	register_setting(
		'wpwisebones_options_group',
		'wpwisebones_options',
		array(
			'sanitize_callback' => 'wpwisebones_sanitize_options',
		)
	);

	/* â”€â”€ Section: General â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
	add_settings_section(
		'wpwisebones_section_general',
		__( 'General Settings', 'wpwisebones' ),
		'__return_false',
		'wpwisebones-theme-options'
	);

	$general_fields = array(
		'preloader'        => array( __( 'Enable Preloader', 'wpwisebones' ), 'checkbox' ),
		'smooth_scroll'    => array( __( 'Enable Smooth Scroll', 'wpwisebones' ), 'checkbox' ),
		'back_to_top'      => array( __( 'Back to Top Button', 'wpwisebones' ), 'checkbox' ),
		'breadcrumbs'      => array( __( 'Show Breadcrumbs', 'wpwisebones' ), 'checkbox' ),
		'author_box'       => array( __( 'Show Author Box on Singles', 'wpwisebones' ), 'checkbox' ),
		'related_posts'    => array( __( 'Show Related Posts', 'wpwisebones' ), 'checkbox' ),
		'reading_time'     => array( __( 'Show Reading Time', 'wpwisebones' ), 'checkbox' ),
		'social_share'     => array( __( 'Show Social Share Buttons', 'wpwisebones' ), 'checkbox' ),
		'posts_per_page'   => array( __( 'Posts Per Page (archive)', 'wpwisebones' ), 'number' ),
		'excerpt_length'   => array( __( 'Excerpt Word Count', 'wpwisebones' ), 'number' ),
		'copyright_text'   => array( __( 'Copyright Text', 'wpwisebones' ), 'text' ),
		'custom_css'       => array( __( 'Custom CSS', 'wpwisebones' ), 'textarea' ),
		'custom_js_head'   => array( __( 'Custom JS (head)', 'wpwisebones' ), 'textarea' ),
		'custom_js_footer' => array( __( 'Custom JS (footer)', 'wpwisebones' ), 'textarea' ),
	);

	foreach ( $general_fields as $id => [ $label, $type ] ) {
		add_settings_field(
			'wpwisebones_' . $id,
			$label,
			'wpwisebones_render_field',
			'wpwisebones-theme-options',
			'wpwisebones_section_general',
			array(
				'id'   => $id,
				'type' => $type,
			)
		);
	}

	/* â”€â”€ Section: Performance â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
	add_settings_section(
		'wpwisebones_section_perf',
		__( 'Performance', 'wpwisebones' ),
		'__return_false',
		'wpwisebones-theme-options'
	);

	$perf_fields = array(
		'disable_emoji'     => array( __( 'Disable WordPress Emojis', 'wpwisebones' ), 'checkbox' ),
		'disable_embeds'    => array( __( 'Disable WordPress oEmbeds', 'wpwisebones' ), 'checkbox' ),
		'disable_xmlrpc'    => array( __( 'Disable XML-RPC', 'wpwisebones' ), 'checkbox' ),
		'remove_query_vars' => array( __( 'Remove Version Query Strings', 'wpwisebones' ), 'checkbox' ),
		'defer_scripts'     => array( __( 'Defer Non-Essential Scripts', 'wpwisebones' ), 'checkbox' ),
	);

	foreach ( $perf_fields as $id => [ $label, $type ] ) {
		add_settings_field(
			'wpwisebones_' . $id,
			$label,
			'wpwisebones_render_field',
			'wpwisebones-theme-options',
			'wpwisebones_section_perf',
			array(
				'id'   => $id,
				'type' => $type,
			)
		);
	}
}

/* â”€â”€ Field renderer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpwisebones_render_field( array $args ) {
	$options = get_option( 'wpwisebones_options', array() );
	$id      = $args['id'];
	$type    = $args['type'];
	$val     = $options[ $id ] ?? '';
	$name    = 'wpwisebones_options[' . esc_attr( $id ) . ']';

	switch ( $type ) {
		case 'checkbox':
			echo '<input type="checkbox" id="wpwisebones_' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1"' . checked( 1, $val, false ) . '>';
			break;
		case 'number':
			echo '<input type="number" id="wpwisebones_' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '" class="small-text">';
			break;
		case 'textarea':
			echo '<textarea id="wpwisebones_' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="5" class="large-text code">' . esc_textarea( $val ) . '</textarea>';
			break;
		default:
			echo '<input type="text" id="wpwisebones_' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '" class="regular-text">';
	}
}

/* â”€â”€ Sanitize callback â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpwisebones_sanitize_options( $input ): array {
	if ( ! is_array( $input ) ) {
		$input = array();
	}
	$out        = array();
	$checkboxes = array(
		'preloader',
		'smooth_scroll',
		'back_to_top',
		'breadcrumbs',
		'author_box',
		'related_posts',
		'reading_time',
		'social_share',
		'disable_emoji',
		'disable_embeds',
		'disable_xmlrpc',
		'remove_query_vars',
		'defer_scripts',
	);
	foreach ( $checkboxes as $key ) {
		$out[ $key ] = ! empty( $input[ $key ] ) ? 1 : 0;
	}
	$out['posts_per_page']   = absint( $input['posts_per_page'] ?? 10 );
	$out['excerpt_length']   = absint( $input['excerpt_length'] ?? 25 );
	$out['copyright_text']   = wp_kses_post( $input['copyright_text'] ?? '' );
	$out['custom_css']       = wp_strip_all_tags( $input['custom_css'] ?? '' );
	$out['custom_js_head']   = wp_strip_all_tags( $input['custom_js_head'] ?? '' );
	$out['custom_js_footer'] = wp_strip_all_tags( $input['custom_js_footer'] ?? '' );
	return $out;
}

/* â”€â”€ Apply performance options on init â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'init', 'wpwisebones_apply_performance_options' );
function wpwisebones_apply_performance_options() {
	$o = get_option( 'wpwisebones_options', array() );

	if ( ! empty( $o['disable_emoji'] ) ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	}

	if ( ! empty( $o['disable_xmlrpc'] ) ) {
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	if ( ! empty( $o['remove_query_vars'] ) ) {
		add_filter( 'style_loader_src', 'wpwisebones_remove_query_strings', 10, 2 );
		add_filter( 'script_loader_src', 'wpwisebones_remove_query_strings', 10, 2 );
	}

	if ( ! empty( $o['disable_embeds'] ) ) {
		add_filter( 'embed_oembed_discover', '__return_false' );
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
		add_filter( 'rewrite_rules_array', 'wpwisebones_disable_embeds_rewrites' );
	}

	if ( ! empty( $o['defer_scripts'] ) ) {
		add_filter( 'script_loader_tag', 'wpwisebones_defer_scripts_filter', 10, 3 );
	}
}

function wpwisebones_disable_embeds_rewrites( array $rules ): array {
	foreach ( $rules as $rule => $rewrite ) {
		if ( false !== strpos( $rewrite, 'embed=true' ) ) {
			unset( $rules[ $rule ] );
		}
	}
	return $rules;
}

function wpwisebones_defer_scripts_filter( string $tag, string $handle, string $src ): string {
	$skip = array( 'jquery', 'jquery-core', 'jquery-migrate', 'bootstrap', 'comment-reply' );
	if ( is_admin() || in_array( $handle, $skip, true ) ) {
		return $tag;
	}
	if ( false !== strpos( $tag, ' defer' ) || false !== strpos( $tag, ' async' ) ) {
		return $tag;
	}
	return str_replace( ' src=', ' defer src=', $tag );
}

function wpwisebones_remove_query_strings( string $src ): string {
	if ( strpos( $src, '?ver=' ) !== false ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

/* â”€â”€ Output custom CSS/JS from options â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_head', 'wpwisebones_output_custom_head', 100 );
function wpwisebones_output_custom_head() {
	$o = get_option( 'wpwisebones_options', array() );
	if ( ! empty( $o['custom_css'] ) ) {
		echo '<style id="wpwisebones-custom-css">' . wp_strip_all_tags( $o['custom_css'] ) . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS cannot be further escaped; strip_all_tags removes injected HTML.
	}
	if ( ! empty( $o['custom_js_head'] ) ) {
		echo '<script id="wpwisebones-custom-js-head">' . wp_strip_all_tags( $o['custom_js_head'] ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JS cannot be further escaped; strip_all_tags removes injected HTML.
	}
}

add_action( 'wp_footer', 'wpwisebones_output_custom_footer', 100 );
function wpwisebones_output_custom_footer() {
	$o = get_option( 'wpwisebones_options', array() );
	if ( ! empty( $o['custom_js_footer'] ) ) {
		echo '<script id="wpwisebones-custom-js-footer">' . wp_strip_all_tags( $o['custom_js_footer'] ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JS cannot be further escaped; strip_all_tags removes injected HTML.
	}
}

/* â”€â”€ Admin page HTML â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpwisebones_admin_options_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p class="description">
			<?php
			printf(
				/* translators: %s: Customizer link */
				esc_html__( 'Configure display and performance options below, or use the %s for live preview.', 'wpwisebones' ),
				'<a href="' . esc_url( admin_url( 'customize.php' ) ) . '">' . esc_html__( 'Customizer', 'wpwisebones' ) . '</a>'
			);
			?>
		</p>

		<form action="options.php" method="post">
			<?php
			settings_fields( 'wpwisebones_options_group' );
			do_settings_sections( 'wpwisebones-theme-options' );
			submit_button( __( 'Save Options', 'wpwisebones' ) );
			?>
		</form>

		<hr>

		<h2><?php esc_html_e( 'Companion Plugin: WPWiseBones Shortcodes', 'wpwisebones' ); ?></h2>

		<?php if ( wpwisebones_companion_active() ) : ?>
		<div class="notice notice-success inline">
			<p>
				<strong><?php esc_html_e( 'WPWiseBones Shortcodes plugin is active.', 'wpwisebones' ); ?></strong>
				&mdash;
				<a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>">
					<?php esc_html_e( 'Manage Plugins', 'wpwisebones' ); ?>
				</a>
			</p>
		</div>
		<?php else : ?>
		<div class="notice notice-warning inline">
			<p>
				<strong><?php esc_html_e( 'WPWiseBones Shortcodes plugin is not installed.', 'wpwisebones' ); ?></strong>
				<?php esc_html_e( 'Install the free companion plugin to add 17 Bootstrap 5 shortcodes to your posts and pages.', 'wpwisebones' ); ?>
			</p>
			<p>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=wisebones-shortcodes' ), 'install-plugin_wisebones-shortcodes' ) ); ?>" class="button button-primary">
					<?php esc_html_e( 'Install WPWiseBones Shortcodes', 'wpwisebones' ); ?>
				</a>
			</p>
		</div>
		<?php endif; ?>

		<h3><?php esc_html_e( 'Shortcode Reference', 'wpwisebones' ); ?></h3>
		<p class="description"><?php esc_html_e( 'These shortcodes are available after installing the WPWiseBones Shortcodes plugin.', 'wpwisebones' ); ?></p>

		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Shortcode', 'wpwisebones' ); ?></th>
					<th><?php esc_html_e( 'Description', 'wpwisebones' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$shortcodes = array(
				'[wpb_alert type="success" dismissible="true"]Message[/wpb_alert]' => __( 'Bootstrap dismissible alert', 'wpwisebones' ),
				'[wpb_button url="/page" style="primary" size="lg" icon="bi-envelope"]Label[/wpb_button]' => __( 'Button with icon support', 'wpwisebones' ),
				'[wpb_card title="Title" image="URL" btn_text="More" btn_url="#"]Body[/wpb_card]' => __( 'Bootstrap card component', 'wpwisebones' ),
				'[wpb_accordion][wpb_accordion_item title="Q"]A[/wpb_accordion_item][/wpb_accordion]' => __( 'Accordion / FAQ', 'wpwisebones' ),
				'[wpb_tabs][wpb_tab title="Tab 1" active="true"]Content[/wpb_tab][/wpb_tabs]' => __( 'Tabbed content', 'wpwisebones' ),
				'[wpb_row gutter="4"][wpb_col size="6"]Left[/wpb_col][wpb_col size="6"]Right[/wpb_col][/wpb_row]' => __( 'Bootstrap grid columns', 'wpwisebones' ),
				'[wpb_cta heading="Ready?" btn_text="Start" btn_url="/contact"]Subtext[/wpb_cta]' => __( 'Call-to-action banner', 'wpwisebones' ),
				'[wpb_icon_box icon="bi-rocket" title="Fast"]Description[/wpb_icon_box]' => __( 'Icon feature box', 'wpwisebones' ),
				'[wpb_progress label="HTML" value="90" color="primary"]' => __( 'Animated progress bar', 'wpwisebones' ),
				'[wpb_testimonial author="Jane Doe" role="CEO" stars="5"]Quote[/wpb_testimonial]' => __( 'Star-rated testimonial', 'wpwisebones' ),
				'[wpb_countdown date="2025-12-31 23:59:59" label="Launching in"]' => __( 'Live countdown timer', 'wpwisebones' ),
				'[wpb_posts count="3" columns="3" category="news" show_excerpt="true"]' => __( 'Post grid from query', 'wpwisebones' ),
				'[wpb_modal title="Title" btn_text="Open"]Modal body[/wpb_modal]' => __( 'Bootstrap modal popup', 'wpwisebones' ),
				'[wpb_badge color="danger" pill="true"]Hot[/wpb_badge]' => __( 'Inline badge / label', 'wpwisebones' ),
				'[wpb_divider text="OR" style="dashed"]' => __( 'Styled divider / HR', 'wpwisebones' ),
				'[wpb_map src="https://maps.google.com/maps?q=...&output=embed" height="400"]' => __( 'Responsive map embed', 'wpwisebones' ),
				'[wpb_contact_info phone="+1 555 0100" email="hello@example.com" address="123 Main St"]' => __( 'Contact information list', 'wpwisebones' ),
			);
			foreach ( $shortcodes as $sc => $desc ) :
				?>
				<tr>
					<td><code><?php echo esc_html( $sc ); ?></code></td>
					<td><?php echo esc_html( $desc ); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/* â”€â”€ Admin footer credit (this page only) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_filter( 'admin_footer_text', 'wpwisebones_admin_footer_credit' );
function wpwisebones_admin_footer_credit( string $text ): string {
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_wpwisebones-theme-options' === $screen->id ) {
		return sprintf(
			/* translators: %s: wprealwise.com link */
			__( 'WPWiseBones &mdash; crafted with &#10084; by %s', 'wpwisebones' ),
			'<a href="' . esc_url( WPWISEBONES_AUTHOR_URL ) . '" target="_blank" rel="noopener noreferrer">wprealwise.com</a>'
		);
	}
	return $text;
}
