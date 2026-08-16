<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

// Remove dismissed notice flag stored per-user.
delete_metadata( 'user', 0, 'wpbs_theme_notice_dismissed', '', true );
