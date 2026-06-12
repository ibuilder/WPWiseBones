<?php
/**
 * Theme Options admin page (Settings > WPWiseBones).
 */

defined( 'ABSPATH' ) || exit;

// Author URL constants — used throughout this file
if ( ! defined( 'WPB_AUTHOR_URL' ) )   define( 'WPB_AUTHOR_URL',   WPB_AUTHOR_URL );
if ( ! defined( 'WPB_DOCS_URL' ) )     define( 'WPB_DOCS_URL',     WPB_DOCS_URL );
if ( ! defined( 'WPB_THEME_URL' ) )    define( 'WPB_THEME_URL',    WPB_THEME_URL );
if ( ! defined( 'WPB_SUPPORT_URL' ) )  define( 'WPB_SUPPORT_URL',  'https://wprealwise.com/support' );

add_action( 'admin_menu', 'wpb_add_admin_menu' );

function wpb_add_admin_menu() {
    add_theme_page(
        __( 'WPWiseBones Options', 'wpwisebones' ),
        __( 'Theme Options', 'wpwisebones' ),
        'manage_options',
        'wpb-theme-options',
        'wpb_admin_options_page'
    );
}

add_action( 'admin_init', 'wpb_admin_settings_init' );

function wpb_admin_settings_init() {
    register_setting( 'wpb_options_group', 'wpb_options', [
        'sanitize_callback' => 'wpb_sanitize_options',
    ] );

    /* â”€â”€ Section: General â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    add_settings_section(
        'wpb_section_general',
        __( 'General Settings', 'wpwisebones' ),
        '__return_false',
        'wpb-theme-options'
    );

    $general_fields = [
        'preloader'        => [ __( 'Enable Preloader', 'wpwisebones' ),          'checkbox' ],
        'smooth_scroll'    => [ __( 'Enable Smooth Scroll', 'wpwisebones' ),      'checkbox' ],
        'back_to_top'      => [ __( 'Back to Top Button', 'wpwisebones' ),        'checkbox' ],
        'breadcrumbs'      => [ __( 'Show Breadcrumbs', 'wpwisebones' ),          'checkbox' ],
        'author_box'       => [ __( 'Show Author Box on Singles', 'wpwisebones' ),'checkbox' ],
        'related_posts'    => [ __( 'Show Related Posts', 'wpwisebones' ),        'checkbox' ],
        'reading_time'     => [ __( 'Show Reading Time', 'wpwisebones' ),         'checkbox' ],
        'social_share'     => [ __( 'Show Social Share Buttons', 'wpwisebones' ), 'checkbox' ],
        'posts_per_page'   => [ __( 'Posts Per Page (archive)', 'wpwisebones' ),  'number'   ],
        'excerpt_length'   => [ __( 'Excerpt Word Count', 'wpwisebones' ),        'number'   ],
        'copyright_text'   => [ __( 'Copyright Text', 'wpwisebones' ),            'text'     ],
        'custom_css'       => [ __( 'Custom CSS', 'wpwisebones' ),                'textarea' ],
        'custom_js_head'   => [ __( 'Custom JS (head)', 'wpwisebones' ),          'textarea' ],
        'custom_js_footer' => [ __( 'Custom JS (footer)', 'wpwisebones' ),        'textarea' ],
    ];

    foreach ( $general_fields as $id => [ $label, $type ] ) {
        add_settings_field(
            'wpb_' . $id,
            $label,
            'wpb_render_field',
            'wpb-theme-options',
            'wpb_section_general',
            [ 'id' => $id, 'type' => $type ]
        );
    }

    /* â”€â”€ Section: Performance â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    add_settings_section(
        'wpb_section_perf',
        __( 'Performance', 'wpwisebones' ),
        '__return_false',
        'wpb-theme-options'
    );

    $perf_fields = [
        'disable_emoji'     => [ __( 'Disable WordPress Emojis', 'wpwisebones' ),  'checkbox' ],
        'disable_embeds'    => [ __( 'Disable WordPress oEmbeds', 'wpwisebones' ),  'checkbox' ],
        'disable_xmlrpc'    => [ __( 'Disable XML-RPC', 'wpwisebones' ),            'checkbox' ],
        'remove_query_vars' => [ __( 'Remove Version Query Strings', 'wpwisebones' ),'checkbox' ],
        'defer_scripts'     => [ __( 'Defer Non-Essential Scripts', 'wpwisebones' ), 'checkbox' ],
    ];

    foreach ( $perf_fields as $id => [ $label, $type ] ) {
        add_settings_field(
            'wpb_' . $id,
            $label,
            'wpb_render_field',
            'wpb-theme-options',
            'wpb_section_perf',
            [ 'id' => $id, 'type' => $type ]
        );
    }
}

function wpb_render_field( array $args ) {
    $options = get_option( 'wpb_options', [] );
    $id      = $args['id'];
    $type    = $args['type'];
    $val     = $options[ $id ] ?? '';
    $name    = 'wpb_options[' . esc_attr( $id ) . ']';

    switch ( $type ) {
        case 'checkbox':
            echo '<input type="checkbox" id="wpb_' . esc_attr( $id ) . '" name="' . $name . '" value="1"' . checked( 1, $val, false ) . '>';
            break;
        case 'number':
            echo '<input type="number" id="wpb_' . esc_attr( $id ) . '" name="' . $name . '" value="' . esc_attr( $val ) . '" class="small-text">';
            break;
        case 'textarea':
            echo '<textarea id="wpb_' . esc_attr( $id ) . '" name="' . $name . '" rows="5" class="large-text code">' . esc_textarea( $val ) . '</textarea>';
            break;
        default:
            echo '<input type="text" id="wpb_' . esc_attr( $id ) . '" name="' . $name . '" value="' . esc_attr( $val ) . '" class="regular-text">';
    }
}

function wpb_sanitize_options( array $input ): array {
    $out = [];
    $checkboxes = [ 'preloader','smooth_scroll','back_to_top','breadcrumbs','author_box','related_posts','reading_time','social_share','disable_emoji','disable_embeds','disable_xmlrpc','remove_query_vars','defer_scripts' ];
    foreach ( $checkboxes as $key ) {
        $out[ $key ] = ! empty( $input[ $key ] ) ? 1 : 0;
    }
    $out['posts_per_page']   = absint( $input['posts_per_page']   ?? 10 );
    $out['excerpt_length']   = absint( $input['excerpt_length']   ?? 25 );
    $out['copyright_text']   = wp_kses_post( $input['copyright_text']   ?? '' );
    $out['custom_css']       = wp_strip_all_tags( $input['custom_css']       ?? '' );
    $out['custom_js_head']   = wp_strip_all_tags( $input['custom_js_head']   ?? '' );
    $out['custom_js_footer'] = wp_strip_all_tags( $input['custom_js_footer'] ?? '' );
    return $out;
}

/* â”€â”€ Apply performance options â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'init', 'wpb_apply_performance_options' );
function wpb_apply_performance_options() {
    $o = get_option( 'wpb_options', [] );

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
        add_filter( 'style_loader_src',  'wpb_remove_query_strings', 10, 2 );
        add_filter( 'script_loader_src', 'wpb_remove_query_strings', 10, 2 );
    }

    if ( ! empty( $o['disable_embeds'] ) ) {
        add_filter( 'embed_oembed_discover', '__return_false' );
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
        add_filter( 'rewrite_rules_array', 'wpb_disable_embeds_rewrites' );
    }

    if ( ! empty( $o['defer_scripts'] ) ) {
        add_filter( 'script_loader_tag', 'wpb_defer_scripts_filter', 10, 3 );
    }
}

/**
 * Remove oEmbed rewrite rules.
 */
function wpb_disable_embeds_rewrites( array $rules ): array {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    }
    return $rules;
}

/**
 * Add defer attribute to non-essential front-end scripts.
 * Skips jQuery, Bootstrap, comment-reply, and any script already marked async/defer.
 */
function wpb_defer_scripts_filter( string $tag, string $handle, string $src ): string {
    $skip = [ 'jquery', 'jquery-core', 'jquery-migrate', 'bootstrap', 'comment-reply' ];
    if ( is_admin() || in_array( $handle, $skip, true ) ) {
        return $tag;
    }
    if ( false !== strpos( $tag, ' defer' ) || false !== strpos( $tag, ' async' ) ) {
        return $tag;
    }
    return str_replace( ' src=', ' defer src=', $tag );
}

function wpb_remove_query_strings( string $src ): string {
    if ( strpos( $src, '?ver=' ) !== false ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}

/* â”€â”€ Output custom CSS/JS from options â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_head', 'wpb_output_custom_head', 100 );
function wpb_output_custom_head() {
    $o = get_option( 'wpb_options', [] );
    if ( ! empty( $o['custom_css'] ) ) {
        echo '<style id="wpb-custom-css">' . wp_strip_all_tags( $o['custom_css'] ) . '</style>' . "\n";
    }
    if ( ! empty( $o['custom_js_head'] ) ) {
        echo '<script id="wpb-custom-js-head">' . wp_strip_all_tags( $o['custom_js_head'] ) . '</script>' . "\n";
    }
}

add_action( 'wp_footer', 'wpb_output_custom_footer', 100 );
function wpb_output_custom_footer() {
    $o = get_option( 'wpb_options', [] );
    if ( ! empty( $o['custom_js_footer'] ) ) {
        echo '<script id="wpb-custom-js-footer">' . wp_strip_all_tags( $o['custom_js_footer'] ) . '</script>' . "\n";
    }
}

/* â”€â”€ Admin page HTML â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_admin_options_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <div class=”wpb-admin-header” style=”background:linear-gradient(135deg,#0d6efd,#6610f2);color:#fff;padding:20px 24px;border-radius:8px;margin-bottom:24px;display:flex;align-items:center;gap:16px;justify-content:space-between”>
            <div style=”display:flex;align-items:center;gap:14px”>
                <span style=”font-size:2.2rem;line-height:1”>&#9889;</span>
                <div>
                    <strong style=”font-size:1.15rem;display:block”>WPWiseBones &mdash; v<?php echo esc_html( WPB_VERSION ); ?></strong>
                    <small style=”opacity:.85”>
                        <?php esc_html_e( 'Configure your theme or use the', 'wpwisebones' ); ?>
                        <a href=”<?php echo esc_url( admin_url( 'customize.php' ) ); ?>” style=”color:#fff;text-decoration:underline”><?php esc_html_e( 'Customizer', 'wpwisebones' ); ?></a>
                        <?php esc_html_e( 'for live preview.', 'wpwisebones' ); ?>
                    </small>
                </div>
            </div>
            <div style=”text-align:right;opacity:.85;font-size:.8rem;line-height:1.6”>
                <?php esc_html_e( 'Built &amp; maintained by', 'wpwisebones' ); ?><br>
                <a href=”https://wprealwise.com” target=”_blank” rel=”noopener noreferrer” style=”color:#fff;font-weight:700;font-size:.95rem;text-decoration:none”>
                    &#127758; <?php echo esc_html( wp_parse_url( WPB_AUTHOR_URL, PHP_URL_HOST ) ); ?>
                </a>
            </div>
        </div>

        <form action="options.php" method="post">
            <?php
            settings_fields( 'wpb_options_group' );
            do_settings_sections( 'wpb-theme-options' );
            submit_button( __( 'Save Options', 'wpwisebones' ) );
            ?>
        </form>

        <hr>

        <!-- ===== COMPANION PLUGIN SECTION ===== -->
        <h2><?php esc_html_e( 'Companion Plugin: WPWiseBones Shortcodes', 'wpwisebones' ); ?></h2>

        <?php if ( wpb_companion_active() ) : ?>
        <div style="background:#d1e7dd;border:1px solid #a3cfbb;border-radius:6px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:12px">
            <span style="font-size:1.4rem">&#10003;</span>
            <div>
                <strong><?php esc_html_e( 'WPWiseBones Shortcodes plugin is active!', 'wpwisebones' ); ?></strong>
                &mdash;
                <a href="<?php echo esc_url( admin_url( 'plugins.php?page=wisebones-shortcodes' ) ); ?>">
                    <?php esc_html_e( 'View Shortcode Reference', 'wpwisebones' ); ?>
                </a>
            </div>
        </div>
        <?php else : ?>
        <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:6px;padding:14px 18px;margin-bottom:20px">
            <strong>&#9888; <?php esc_html_e( 'Shortcodes plugin not installed', 'wpwisebones' ); ?></strong><br>
            <p style="margin:.5rem 0"><?php esc_html_e( 'This theme works with a free companion plugin that adds 17 Bootstrap 5 shortcodes: alerts, buttons, cards, tabs, accordions, modals, countdown timers, post grids, and more.', 'wpwisebones' ); ?></p>
            <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=wisebones-shortcodes' ), 'install-plugin_wisebones-shortcodes' ) ); ?>" class="button button-primary">
                &#8659; <?php esc_html_e( 'Install WPWiseBones Shortcodes', 'wpwisebones' ); ?>
            </a>
            &nbsp;
            <a href=WPB_THEME_URL . '#shortcodes' target="_blank" rel="noopener noreferrer" class="button">
                <?php esc_html_e( 'Learn More', 'wpwisebones' ); ?>
            </a>
        </div>
        <?php endif; ?>

        <h3><?php esc_html_e( 'Available Shortcodes (requires companion plugin)', 'wpwisebones' ); ?></h3>
        <p style="color:#646970"><?php esc_html_e( 'Install the WPWiseBones Shortcodes plugin to use the following shortcodes in your posts, pages, and widgets.', 'wpwisebones' ); ?></p>

        <h2><?php esc_html_e( 'Shortcode Reference', 'wpwisebones' ); ?></h2>
        <table class="widefat striped">
            <thead><tr><th><?php esc_html_e( 'Shortcode', 'wpwisebones' ); ?></th><th><?php esc_html_e( 'Description', 'wpwisebones' ); ?></th></tr></thead>
            <tbody>
            <?php
            $shortcodes = [
                '[wpb_alert type="success" dismissible="true"]Text[/wpb_alert]'           => 'Bootstrap dismissible alert',
                '[wpb_button url="/page" style="primary" size="lg"]Click[/wpb_button]'     => 'Button with icon support',
                '[wpb_card title="Title" image="URL" btn_text="More" btn_url="#"]â€¦[/wpb_card]' => 'Bootstrap card',
                '[wpb_accordion][wpb_accordion_item title="Q"]A[/wpb_accordion_item][/wpb_accordion]' => 'Accordion / FAQ',
                '[wpb_tabs][wpb_tab title="Tab 1" active="true"]â€¦[/wpb_tab][/wpb_tabs]'   => 'Tabbed content',
                '[wpb_row gutter="4"][wpb_col size="6"]â€¦[/wpb_col][/wpb_row]'             => 'Bootstrap grid columns',
                '[wpb_cta heading="CTA" btn_text="Go" btn_url="#"]â€¦[/wpb_cta]'           => 'Call-to-action banner',
                '[wpb_icon_box icon="bi-star" title="Title"]â€¦[/wpb_icon_box]'             => 'Icon feature box',
                '[wpb_progress label="HTML" value="90" color="primary"]'                  => 'Animated progress bar',
                '[wpb_testimonial author="Jane" role="CEO" stars="5"]â€¦[/wpb_testimonial]' => 'Testimonial quote',
                '[wpb_countdown date="2025-12-31"]'                                        => 'Live countdown timer',
                '[wpb_posts count="3" columns="3" category="news"]'                       => 'Post grid from query',
                '[wpb_modal title="Title" btn_text="Open"]â€¦[/wpb_modal]'                  => 'Bootstrap modal popup',
                '[wpb_badge color="danger" pill="true"]Hot[/wpb_badge]'                   => 'Inline badge / label',
                '[wpb_divider text="OR" style="dashed"]'                                  => 'Styled divider / HR',
                '[wpb_map src="embed-url" height="400"]'                                  => 'Responsive map embed',
                '[wpb_contact_info phone="+1â€¦" email="â€¦" address="â€¦"]'                   => 'Contact information list',
            ];
            foreach ( $shortcodes as $sc => $desc ) :
                ?>
                <tr>
                    <td><code><?php echo esc_html( $sc ); ?></code></td>
                    <td><?php echo esc_html( $desc ); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top:32px;padding:16px 20px;background:#f6f7f7;border-left:4px solid #0d6efd;border-radius:4px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
            <div>
                <strong>WPWiseBones v<?php echo esc_html( WPB_VERSION ); ?></strong> &mdash;
                <?php esc_html_e( 'A professional Bootstrap 5 WordPress starter theme.', 'wpwisebones' ); ?>
            </div>
            <div>
                <a href=WPB_AUTHOR_URL target="_blank" rel="noopener noreferrer" class="button">
                    &#127758; <?php echo esc_html( wp_parse_url( WPB_AUTHOR_URL, PHP_URL_HOST ) ); ?>
                </a>
                &nbsp;
                <a href=WPB_DOCS_URL target="_blank" rel="noopener noreferrer" class="button">
                    &#128196; <?php esc_html_e( 'Documentation', 'wpwisebones' ); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}

/* ── Admin footer credit ─────────────────────────────────────── */

add_filter( 'admin_footer_text', 'wpb_admin_footer_credit' );
function wpb_admin_footer_credit( string $text ): string {
    $screen = get_current_screen();
    if ( $screen && false !== strpos( $screen->id ?? '', 'wprealwise' ) ) {
        return sprintf(
            /* translators: %s: wprealwise.com link */
            __( 'WPWiseBones &mdash; crafted with &#10084; by %s', 'wpwisebones' ),
            '<a href=WPB_AUTHOR_URL target="_blank" rel="noopener noreferrer">wprealwise.com</a>'
        );
    }
    return $text;
}
