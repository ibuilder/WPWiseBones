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

define( 'WPWISEBONES_COMPANION_SLUG', 'wisebones-shortcodes/wisebones-shortcodes.php' );
define( 'WPWISEBONES_COMPANION_VERSION', '1.0.3' );
define( 'WPWISEBONES_COMPANION_URL', WPWISEBONES_THEME_URL . '#shortcodes' );

/* ── Helper: is companion plugin active? ────────────────────── */

function wpwisebones_companion_active(): bool {
	return defined( 'WPBS_VERSION' );
}

/* ── Admin notice when companion plugin is not installed ──────── */

add_action( 'admin_notices', 'wpwisebones_companion_notice' );

function wpwisebones_companion_notice() {
	if ( wpwisebones_companion_active() ) {
		return;
	}

	// Only show to users who can install plugins
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	// Respect dismissal (stored per-user)
	$dismissed = get_user_meta( get_current_user_id(), 'wpwisebones_companion_dismissed', true );
	if ( $dismissed ) {
		return;
	}

	// Only show on theme/plugin admin screens, not everywhere
	$screen  = get_current_screen();
	$show_on = array( 'plugins', 'themes', 'appearance_page_wpwisebones-theme-options' );
	if ( ! $screen || ! in_array( $screen->id, $show_on, true ) ) {
		return;
	}

	$install_url = wp_nonce_url(
		admin_url( 'update.php?action=install-plugin&plugin=wisebones-shortcodes' ),
		'install-plugin_wisebones-shortcodes'
	);

	$dismiss_url = wp_nonce_url(
		admin_url( 'admin-post.php?action=wpwisebones_dismiss_companion_notice' ),
		'wpwisebones_dismiss_companion'
	);

	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<strong><?php esc_html_e( 'WPWiseBones Shortcodes', 'wpwisebones' ); ?></strong> &mdash;
			<?php esc_html_e( 'Install the free companion plugin to add 17 Bootstrap 5 shortcodes (alerts, cards, tabs, accordions, modals, and more) to your posts and pages.', 'wpwisebones' ); ?>
		</p>
		<p>
			<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary">
				<?php esc_html_e( 'Install WiseBones Shortcodes', 'wpwisebones' ); ?>
			</a>
			&nbsp;
			<a href="<?php echo esc_url( 'https://wordpress.org/plugins/wisebones-shortcodes/' ); ?>" class="button" target="_blank" rel="noopener noreferrer">
				<?php esc_html_e( 'View on WordPress.org', 'wpwisebones' ); ?>
			</a>
			&nbsp;
			<a href="<?php echo esc_url( $dismiss_url ); ?>">
				<?php esc_html_e( 'Dismiss', 'wpwisebones' ); ?>
			</a>
		</p>
	</div>
	<?php
}

/* ── Handle notice dismissal ────────────────────────────────── */

add_action( 'admin_post_wpwisebones_dismiss_companion_notice', 'wpwisebones_handle_companion_dismiss' );

function wpwisebones_handle_companion_dismiss() {
	check_admin_referer( 'wpwisebones_dismiss_companion' );
	if ( current_user_can( 'install_plugins' ) ) {
		update_user_meta( get_current_user_id(), 'wpwisebones_companion_dismissed', true );
	}
	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
	exit;
}

