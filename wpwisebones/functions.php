<?php
/**
 * WPWiseBones â€“ functions.php
 * Central loader. Keeps this file thin; logic lives in /inc.
 */

defined( 'ABSPATH' ) || exit;

define( 'WPB_VERSION',   '1.0.2' );
define( 'WPB_DIR',       get_template_directory() );
define( 'WPB_URI',       get_template_directory_uri() );
define( 'WPB_INC',       WPB_DIR . '/inc/' );

// Theme URL constants — used in admin pages and notices
define( 'WPB_AUTHOR_URL',  'https://wprealwise.com' );
define( 'WPB_THEME_URL',   'https://wprealwise.com/wpwisebones' );
define( 'WPB_DOCS_URL',    'https://wprealwise.com/docs' );
define( 'WPB_SUPPORT_URL', 'https://wprealwise.com/support' );

/* â”€â”€ Autoload â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
$wpb_includes = [
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

foreach ( $wpb_includes as $file ) {
    $path = WPB_INC . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}
