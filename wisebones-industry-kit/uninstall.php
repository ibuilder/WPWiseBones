<?php
/**
 * Uninstall: removes the plugin's settings. Entries (listings, projects,
 * leads…) are content and are kept; delete them from their screens first if
 * you want them gone.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'wbik_settings' );
delete_option( 'wbik_rewrite_signature' );
delete_option( 'wbik_starter_log' );
