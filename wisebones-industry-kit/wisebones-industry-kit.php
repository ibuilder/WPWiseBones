<?php
/**
 * Plugin Name:       WiseBones Industry Kit
 * Description:       Content types, lead capture, schema markup and a one-click starter site for real estate, construction and trade businesses. Pairs with the WPWiseBones industry child themes, which decide which content types to switch on; works with any theme.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            WPWiseBones
 * Author URI:        https://wprealwise.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wisebones-industry-kit
 *
 * Copyright (C) 2025 WPWiseBones (https://wprealwise.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

define( 'WBIK_VERSION', '1.0.0' );
define( 'WBIK_FILE', __FILE__ );
define( 'WBIK_DIR', plugin_dir_path( __FILE__ ) );
define( 'WBIK_URI', plugin_dir_url( __FILE__ ) );

foreach ( array( 'config', 'content-types', 'meta-boxes', 'front', 'lead-form', 'schema', 'shortcodes', 'starter', 'admin' ) as $wbik_file ) {
	require_once WBIK_DIR . 'includes/' . $wbik_file . '.php';
}

register_activation_hook( __FILE__, 'wbik_activate' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

/**
 * Register the content types once so their permalinks work straight away.
 */
function wbik_activate() {
	wbik_register_content_types();
	flush_rewrite_rules();
}
