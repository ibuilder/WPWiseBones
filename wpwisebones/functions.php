<?php
/**
 * WPWiseBones â€“ functions.php
 * Central loader. Keeps this file thin; logic lives in /inc.
 */

defined( 'ABSPATH' ) || exit;

define( 'WPWISEBONES_VERSION',   '1.0.7' );
define( 'WPWISEBONES_DIR',       get_template_directory() );
define( 'WPWISEBONES_URI',       get_template_directory_uri() );
define( 'WPWISEBONES_INC',       WPWISEBONES_DIR . '/inc/' );

// Theme URL constants — used in admin pages and notices
define( 'WPWISEBONES_AUTHOR_URL',  'https://wprealwise.com' );
define( 'WPWISEBONES_THEME_URL',   'https://wprealwise.com/wpwisebones' );
define( 'WPWISEBONES_DOCS_URL',    'https://wprealwise.com/docs' );
define( 'WPWISEBONES_SUPPORT_URL', 'https://wprealwise.com/support' );

/* â”€â”€ Autoload â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
$wpwisebones_includes = [
    'setup.php',
    'enqueue.php',
    'nav-menus.php',
    'sidebars.php',
    'template-functions.php',
    'template-tags.php',
    'customizer.php',
    'admin/admin-page.php',
    'admin/meta-boxes.php',
    'widgets/widget-recent-posts.php',
    'widgets/widget-social-links.php',
    'widgets/widget-cta-banner.php',
    'ajax-handlers.php',
    'seo.php',
    'woocommerce.php',
    'dashboard-widget.php',
    'companion-plugin.php',
];

foreach ( $wpwisebones_includes as $file ) {
    $path = WPWISEBONES_INC . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}
