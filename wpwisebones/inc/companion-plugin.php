<?php
/**
 * Companion Plugin Integration
 *
 * Detects whether WPWiseBones Shortcodes plugin is active and shows
 * a dismissible admin notice if it is not. Also provides helper
 * functions for theme/plugin communication.
 *
 * Plugin: WPWiseBones Shortcodes
 * Plugin URI: https://wprealwise.com/wpwisebones#shortcodes
 * Plugin slug: wisebones-shortcodes
 */

defined( 'ABSPATH' ) || exit;

/* ── Constants ───────────────────────────────────────────────── */

define( 'WPB_COMPANION_SLUG',    'wisebones-shortcodes/wisebones-shortcodes.php' );
define( 'WPB_COMPANION_VERSION', '1.0.0' );
define( 'WPB_COMPANION_URL',     WPB_THEME_URL . '#shortcodes' );

/* ── Helper: is companion plugin active? ────────────────────── */

function wpb_companion_active(): bool {
    return defined( 'WPBS_VERSION' );
}

/* ── Admin notice when companion plugin is not installed ──────── */

add_action( 'admin_notices', 'wpb_companion_notice' );

function wpb_companion_notice() {
    if ( wpb_companion_active() ) {
        return;
    }

    // Only show to users who can install plugins
    if ( ! current_user_can( 'install_plugins' ) ) {
        return;
    }

    // Respect dismissal (stored per-user)
    $dismissed = get_user_meta( get_current_user_id(), 'wpb_companion_dismissed', true );
    if ( $dismissed ) {
        return;
    }

    // Only show on theme/plugin admin screens, not everywhere
    $screen = get_current_screen();
    $show_on = [ 'dashboard', 'themes', 'plugins', 'appearance_page_wpb-theme-options' ];
    if ( ! $screen || ! in_array( $screen->id, $show_on, true ) ) {
        return;
    }

    $install_url = wp_nonce_url(
        admin_url( 'update.php?action=install-plugin&plugin=wisebones-shortcodes' ),
        'install-plugin_wisebones-shortcodes'
    );

    $dismiss_url = wp_nonce_url(
        admin_url( 'admin-post.php?action=wpb_dismiss_companion_notice' ),
        'wpb_dismiss_companion'
    );

    ?>
    <div class="notice notice-info is-dismissible wpb-companion-notice" style="border-left-color:#0d6efd;padding:16px 20px">
        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
            <div style="flex-grow:1">
                <strong>&#9889; <?php esc_html_e( 'WPWiseBones: Unlock 17 Bootstrap Shortcodes', 'wpwisebones' ); ?></strong><br>
                <span style="color:#646970">
                    <?php esc_html_e( 'Install the free WPWiseBones Shortcodes companion plugin to add Bootstrap alerts, cards, tabs, accordions, modals, countdown timers, and more to your posts and pages.', 'wpwisebones' ); ?>
                </span>
            </div>
            <div style="display:flex;gap:8px;flex-shrink:0;flex-wrap:wrap">
                <a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary">
                    &#8659; <?php esc_html_e( 'Install Plugin', 'wpwisebones' ); ?>
                </a>
                <a href="<?php echo esc_url( WPB_COMPANION_URL ); ?>" class="button" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e( 'Learn More', 'wpwisebones' ); ?>
                </a>
                <a href="<?php echo esc_url( $dismiss_url ); ?>" class="button button-link" style="color:#646970">
                    <?php esc_html_e( 'Dismiss', 'wpwisebones' ); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}

/* ── Handle notice dismissal ────────────────────────────────── */

add_action( 'admin_post_wpb_dismiss_companion_notice', 'wpb_handle_companion_dismiss' );

function wpb_handle_companion_dismiss() {
    check_admin_referer( 'wpb_dismiss_companion' );
    if ( current_user_can( 'install_plugins' ) ) {
        update_user_meta( get_current_user_id(), 'wpb_companion_dismissed', true );
    }
    wp_safe_redirect( wp_get_referer() ?: admin_url() );
    exit;
}

/* ── Show companion status in admin bar (for admins) ─────────── */

add_action( 'admin_bar_menu', 'wpb_admin_bar_companion_status', 100 );

function wpb_admin_bar_companion_status( WP_Admin_Bar $bar ) {
    if ( ! is_admin_bar_showing() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $bar->add_node( [
        'id'     => 'wpb-theme',
        'title'  => '&#9889; WPWiseBones',
        'href'   => admin_url( 'themes.php?page=wpb-theme-options' ),
        'meta'   => [ 'title' => __( 'WPWiseBones Theme Options', 'wpwisebones' ) ],
    ] );

    $bar->add_node( [
        'parent' => 'wpb-theme',
        'id'     => 'wpb-theme-options',
        'title'  => __( 'Theme Options', 'wpwisebones' ),
        'href'   => admin_url( 'themes.php?page=wpb-theme-options' ),
    ] );

    $bar->add_node( [
        'parent' => 'wpb-theme',
        'id'     => 'wpb-customizer',
        'title'  => __( 'Customizer', 'wpwisebones' ),
        'href'   => wp_customize_url(),
    ] );

    if ( wpb_companion_active() ) {
        $bar->add_node( [
            'parent' => 'wpb-theme',
            'id'     => 'wpb-shortcodes',
            'title'  => '&#10003; ' . __( 'Shortcodes Active', 'wpwisebones' ),
            'href'   => admin_url( 'plugins.php?page=wisebones-shortcodes' ),
        ] );
    } else {
        $bar->add_node( [
            'parent' => 'wpb-theme',
            'id'     => 'wpb-shortcodes',
            'title'  => '&#43; ' . __( 'Install Shortcodes Plugin', 'wpwisebones' ),
            'href'   => wp_nonce_url(
                admin_url( 'update.php?action=install-plugin&plugin=wisebones-shortcodes' ),
                'install-plugin_wisebones-shortcodes'
            ),
        ] );
    }
}
