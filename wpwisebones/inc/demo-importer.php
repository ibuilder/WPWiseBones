<?php
/**
 * WPWiseBones Demo Content Importer
 *
 * Appearance → Demo Content
 * One-click install / reset of showcase content.
 * All demo items are tagged _wpb_demo=1 for clean removal.
 */

defined( 'ABSPATH' ) || exit;

/* ── Admin menu ─────────────────────────────────────────────── */

add_action( 'admin_menu', 'wpb_demo_admin_menu' );
function wpb_demo_admin_menu() {
    add_theme_page(
        __( 'Demo Content', 'wpwisebones' ),
        __( 'Demo Content', 'wpwisebones' ),
        'manage_options',
        'wpb-demo-importer',
        'wpb_demo_page'
    );
}

/* ── Admin page UI ──────────────────────────────────────────── */

function wpb_demo_page() {
    $installed = (bool) get_option( 'wpb_demo_installed' );
    $notices   = [];

    if ( isset( $_POST['wpb_demo_action'] ) && check_admin_referer( 'wpb_demo_action_nonce' ) ) {
        $action = sanitize_key( $_POST['wpb_demo_action'] );

        if ( 'install' === $action ) {
            $result = wpb_demo_install();
            if ( is_wp_error( $result ) ) {
                $notices[] = [ 'error', $result->get_error_message() ];
            } else {
                $notices[] = [ 'success', __( 'Demo content installed! Visit your site to see it in action.', 'wpwisebones' ) ];
                $installed  = true;
            }
        } elseif ( 'reset' === $action ) {
            wpb_demo_reset();
            $notices[] = [ 'success', __( 'Demo content removed. Your site is clean again.', 'wpwisebones' ) ];
            $installed  = false;
        }
    }

    $has_shortcodes = function_exists( 'WPBS_VERSION' ) || defined( 'WPBS_VERSION' );
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px">
            &#9889; <?php esc_html_e( 'WPWiseBones — Demo Content', 'wpwisebones' ); ?>
        </h1>

        <?php foreach ( $notices as [ $type, $msg ] ) : ?>
        <div class="notice notice-<?php echo esc_attr( $type ); ?> is-dismissible"><p><?php echo esc_html( $msg ); ?></p></div>
        <?php endforeach; ?>

        <div style="display:flex;gap:24px;flex-wrap:wrap;margin-top:20px">

            <!-- Left: Info card -->
            <div style="flex:1;min-width:300px;background:#fff;border:1px solid #ddd;border-radius:8px;padding:24px">
                <h2 style="margin-top:0"><?php esc_html_e( 'What gets installed', 'wpwisebones' ); ?></h2>
                <ul style="line-height:2">
                    <li>&#10003; <?php esc_html_e( '4 pages — Home, About, Blog, Contact', 'wpwisebones' ); ?></li>
                    <li>&#10003; <?php esc_html_e( '6 sample blog posts with placeholder images', 'wpwisebones' ); ?></li>
                    <li>&#10003; <?php esc_html_e( 'Primary navigation menu (all pages)', 'wpwisebones' ); ?></li>
                    <li>&#10003; <?php esc_html_e( 'Static front page + posts page configured', 'wpwisebones' ); ?></li>
                    <li>&#10003; <?php esc_html_e( 'Hero heading, subheading, and CTA button set', 'wpwisebones' ); ?></li>
                    <li>&#10003; <?php esc_html_e( 'Sidebar and footer widgets populated', 'wpwisebones' ); ?></li>
                    <?php if ( $has_shortcodes ) : ?>
                    <li>&#10003; <strong><?php esc_html_e( 'Full shortcode showcase (plugin detected!)', 'wpwisebones' ); ?></strong></li>
                    <?php else : ?>
                    <li style="color:#888">&#9888; <?php esc_html_e( 'Install WiseBones Shortcodes for the full showcase', 'wpwisebones' ); ?></li>
                    <?php endif; ?>
                </ul>

                <?php if ( $installed ) : ?>
                <div style="background:#d1e7dd;border-radius:6px;padding:12px;margin-top:16px">
                    <strong><?php esc_html_e( 'Demo content is installed.', 'wpwisebones' ); ?></strong>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" style="margin-left:8px">
                        <?php esc_html_e( 'View site &rarr;', 'wpwisebones' ); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Action card -->
            <div style="min-width:260px;background:#fff;border:1px solid #ddd;border-radius:8px;padding:24px;display:flex;flex-direction:column;gap:16px">
                <h2 style="margin-top:0"><?php esc_html_e( 'Actions', 'wpwisebones' ); ?></h2>

                <?php if ( ! $installed ) : ?>
                <form method="post">
                    <?php wp_nonce_field( 'wpb_demo_action_nonce' ); ?>
                    <input type="hidden" name="wpb_demo_action" value="install">
                    <button type="submit" class="button button-primary button-hero" style="width:100%">
                        &#8659; <?php esc_html_e( 'Install Demo Content', 'wpwisebones' ); ?>
                    </button>
                    <p class="description" style="margin-top:8px">
                        <?php esc_html_e( 'Existing content will not be modified.', 'wpwisebones' ); ?>
                    </p>
                </form>
                <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary button-hero" target="_blank" style="width:100%;text-align:center">
                    &#128065; <?php esc_html_e( 'Preview Site', 'wpwisebones' ); ?>
                </a>
                <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button" target="_blank" style="width:100%;text-align:center">
                    &#9881; <?php esc_html_e( 'Open Customizer', 'wpwisebones' ); ?>
                </a>
                <hr>
                <form method="post" onsubmit="return confirm('<?php echo esc_js( __( 'Remove all demo content? This cannot be undone.', 'wpwisebones' ) ); ?>')">
                    <?php wp_nonce_field( 'wpb_demo_action_nonce' ); ?>
                    <input type="hidden" name="wpb_demo_action" value="reset">
                    <button type="submit" class="button" style="width:100%;color:#d63638;border-color:#d63638">
                        &#128465; <?php esc_html_e( 'Remove Demo Content', 'wpwisebones' ); ?>
                    </button>
                </form>
                <?php endif; ?>
            </div>

        </div>

        <!-- Credit -->
        <p style="margin-top:32px;color:#888;font-size:12px">
            WPWiseBones by <a href="https://wprealwise.com" target="_blank" rel="noopener noreferrer">wprealwise.com</a>
        </p>
    </div>
    <?php
}

/* ═══════════════════════════════════════════════════════════════
   INSTALL
   ═══════════════════════════════════════════════════════════════ */

function wpb_demo_install() {
    // Create placeholder images (GD)
    $image_ids = wpb_demo_create_images();

    // Create taxonomy
    $cat_id = wpb_demo_create_category();

    // Create pages + posts
    $home_id    = wpb_demo_create_home_page( $image_ids );
    $about_id   = wpb_demo_create_about_page( $image_ids );
    $blog_id    = wpb_demo_create_blog_page();
    $contact_id = wpb_demo_create_contact_page();
    wpb_demo_create_posts( $cat_id, $image_ids );

    // Navigation
    wpb_demo_create_menu( $home_id, $about_id, $blog_id, $contact_id );

    // Reading settings (static front page)
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front',  $home_id );
    update_option( 'page_for_posts', $blog_id );

    // Customizer settings
    wpb_demo_set_customizer();

    // Widgets
    wpb_demo_setup_widgets();

    update_option( 'wpb_demo_installed', 1 );
    return true;
}

/* ── Placeholder images via GD ──────────────────────────────── */

function wpb_demo_create_images(): array {
    $upload  = wp_upload_dir();
    $ids     = [];
    $colours = [
        [ 13, 110, 253 ],   // Bootstrap primary blue
        [ 25, 135, 84 ],    // Bootstrap success green
        [ 220, 53, 69 ],    // Bootstrap danger red
        [ 255, 193, 7 ],    // Bootstrap warning yellow
        [ 13, 202, 240 ],   // Bootstrap info cyan
        [ 111, 66, 193 ],   // Bootstrap purple
        [ 52, 58, 64 ],     // Bootstrap dark
    ];
    $labels = [
        'Hero', 'Design', 'Development', 'Marketing', 'Strategy', 'Technology', 'Business',
    ];

    if ( ! function_exists( 'imagecreatetruecolor' ) ) {
        return $ids;
    }

    foreach ( $colours as $i => $rgb ) {
        $w  = ( 0 === $i ) ? 1200 : 800;
        $h  = ( 0 === $i ) ? 500  : 450;
        $im = imagecreatetruecolor( $w, $h );

        // Gradient-ish: darker at top, lighter at bottom
        $dark  = imagecolorallocate( $im, (int) ( $rgb[0] * 0.7 ), (int) ( $rgb[1] * 0.7 ), (int) ( $rgb[2] * 0.7 ) );
        $light = imagecolorallocate( $im, min( 255, (int) ( $rgb[0] * 1.3 ) ), min( 255, (int) ( $rgb[1] * 1.3 ) ), min( 255, (int) ( $rgb[2] * 1.3 ) ) );
        for ( $y = 0; $y < $h; $y++ ) {
            $frac = $y / $h;
            $r    = (int) ( $rgb[0] * 0.7 + $rgb[0] * 0.6 * $frac );
            $g    = (int) ( $rgb[1] * 0.7 + $rgb[1] * 0.6 * $frac );
            $b    = (int) ( $rgb[2] * 0.7 + $rgb[2] * 0.6 * $frac );
            $line = imagecolorallocate( $im, min( 255, $r ), min( 255, $g ), min( 255, $b ) );
            imageline( $im, 0, $y, $w, $y, $line );
        }

        // Label text
        $white   = imagecolorallocate( $im, 255, 255, 255 );
        $font    = 5; // built-in GD font
        $label   = $labels[ $i ] ?? 'WPWiseBones';
        $tw      = imagefontwidth( $font ) * strlen( $label );
        $th      = imagefontheight( $font );
        imagestring( $im, $font, (int) ( ( $w - $tw ) / 2 ), (int) ( ( $h - $th ) / 2 ), $label, $white );

        // Save
        $filename = 'wpb-demo-' . $i . '.jpg';
        $filepath = $upload['path'] . '/' . $filename;
        imagejpeg( $im, $filepath, 85 );
        imagedestroy( $im );

        // Register as WP attachment
        $attach_id = wp_insert_attachment( [
            'post_title'     => 'WPWiseBones Demo Image ' . ( $i + 1 ),
            'post_status'    => 'inherit',
            'post_mime_type' => 'image/jpeg',
            'meta_input'     => [ '_wpb_demo' => 1 ],
        ], $filepath );

        if ( ! is_wp_error( $attach_id ) ) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $filepath ) );
            $ids[ $i ] = $attach_id;
        }
    }

    return $ids;
}

/* ── Category ────────────────────────────────────────────────── */

function wpb_demo_create_category(): int {
    $existing = get_term_by( 'slug', 'wpb-demo', 'category' );
    if ( $existing ) {
        return (int) $existing->term_id;
    }
    $result = wp_insert_term( 'WPWiseBones Demo', 'category', [ 'slug' => 'wpb-demo' ] );
    return is_wp_error( $result ) ? 1 : (int) $result['term_id'];
}

/* ── Home page ───────────────────────────────────────────────── */

function wpb_demo_create_home_page( array $image_ids ): int {
    $has_sc = defined( 'WPBS_VERSION' );

    if ( $has_sc ) {
        $content = '
<!-- wp:html -->
[wpb_cta heading="Build Beautiful WordPress Sites Faster" btn_text="Get Started" btn_url="/about" btn_style="light" btn2_text="Learn More" btn2_url="/blog"]
Welcome to WPWiseBones — a production-ready Bootstrap 5 starter theme packed with every feature you need.
[/wpb_cta]
<!-- /wp:html -->

<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="has-text-align-center">Why WPWiseBones?</h2>
<!-- /wp:heading -->

<!-- wp:html -->
[wpb_row gutter="4"]
[wpb_col size="4"][wpb_icon_box icon="bi-lightning-charge-fill" title="Lightning Fast" style="card"]Built on Bootstrap 5.3 — the world\'s most popular CSS framework. No bloat, no compromises.[/wpb_icon_box][/wpb_col]
[wpb_col size="4"][wpb_icon_box icon="bi-palette-fill" title="Fully Customisable" style="card"]Change colours, fonts, layout, and hero content live with the WordPress Customizer.[/wpb_icon_box][/wpb_col]
[wpb_col size="4"][wpb_icon_box icon="bi-phone-fill" title="Mobile-First" style="card"]Pixel-perfect on every device. Built with Bootstrap\'s responsive grid from the ground up.[/wpb_icon_box][/wpb_col]
[/wpb_row]
<!-- /wp:html -->

<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="has-text-align-center">17 Bootstrap Shortcodes Included</h2>
<!-- /wp:heading -->

<!-- wp:html -->
[wpb_tabs style="pills"]
[wpb_tab title="Alerts" icon="bi-bell" active="true"]
[wpb_alert type="success"]This is a <strong>success</strong> alert — great for confirmations and good news.[/wpb_alert]
[wpb_alert type="warning"]This is a <strong>warning</strong> alert — use it to flag important information.[/wpb_alert]
[wpb_alert type="danger" dismissible="true"]This is a <strong>dismissible</strong> danger alert. Click × to close.[/wpb_alert]
[/wpb_tab]
[wpb_tab title="Cards" icon="bi-card-text"]
[wpb_row gutter="3"]
[wpb_col size="4"][wpb_card title="Feature Card" btn_text="Learn More" btn_url="#"]Cards are a flexible Bootstrap component for displaying grouped content.[/wpb_card][/wpb_col]
[wpb_col size="4"][wpb_card title="Another Card" btn_text="Read More" btn_url="#"]Add any content here — text, images, links, or even nested shortcodes.[/wpb_card][/wpb_col]
[wpb_col size="4"][wpb_card title="Third Card" btn_text="View" btn_url="#"]Cards automatically equalise their height in a grid row — fully responsive.[/wpb_card][/wpb_col]
[/wpb_row]
[/wpb_tab]
[wpb_tab title="Progress" icon="bi-bar-chart"]
[wpb_progress label="HTML &amp; CSS" value="95" color="primary"]
[wpb_progress label="Bootstrap 5" value="90" color="success"]
[wpb_progress label="WordPress" value="85" color="info"]
[wpb_progress label="WooCommerce" value="75" color="warning"]
[/wpb_tab]
[/wpb_tabs]
<!-- /wp:html -->

<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="has-text-align-center">FAQ — Accordion Example</h2>
<!-- /wp:heading -->

<!-- wp:html -->
[wpb_accordion]
[wpb_accordion_item title="What is WPWiseBones?" open="true"]WPWiseBones is a production-ready Bootstrap 5 WordPress starter theme packed with shortcodes, widgets, an admin options panel, WooCommerce support, and more.[/wpb_accordion_item]
[wpb_accordion_item title="Do I need to know code to use this theme?"]No! The Customizer lets you change colours, fonts, hero content, and layout without touching any code.[/wpb_accordion_item]
[wpb_accordion_item title="Is it WooCommerce compatible?"]Yes. WPWiseBones includes a full WooCommerce compatibility layer with Bootstrap-styled product grids, cart, and checkout.[/wpb_accordion_item]
[wpb_accordion_item title="Is it free?"]Yes — WPWiseBones is released under the GNU GPL v2 or later and is completely free to use.[/wpb_accordion_item]
[/wpb_accordion]
<!-- /wp:html -->

<!-- wp:html -->
[wpb_row gutter="4"]
[wpb_col size="6"]
[wpb_testimonial author="Sarah Johnson" role="Web Developer" stars="5"]WPWiseBones saved me weeks of work. The Bootstrap 5 integration is seamless and the shortcodes are incredibly versatile.[/wpb_testimonial]
[/wpb_col]
[wpb_col size="6"]
[wpb_testimonial author="Mike Torres" role="Agency Owner" stars="5"]The best WordPress starter theme I\'ve used. The admin options panel is comprehensive and the code quality is excellent.[/wpb_testimonial]
[/wpb_col]
[/wpb_row]

[wpb_cta heading="Ready to Build Something Amazing?" btn_text="View Theme Options" btn_url="/wp-admin/themes.php?page=wpb-theme-options" btn_style="primary" btn2_text="Customise Now" btn2_url="/wp-admin/customize.php"]
WPWiseBones gives you everything you need right out of the box.
[/wpb_cta]
<!-- /wp:html -->
';
    } else {
        $content = '
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">Build Beautiful WordPress Sites Faster</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Welcome to WPWiseBones — a production-ready Bootstrap 5 starter theme packed with every feature you need.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":"2rem"}}} -->
<div class="wp-block-columns">
<div class="wp-block-column">
<h4>&#9889; Lightning Fast</h4>
<p>Built on Bootstrap 5.3 — the world\'s most popular CSS framework. No bloat, no compromises.</p>
</div>
<div class="wp-block-column">
<h4>&#127912; Fully Customisable</h4>
<p>Change colours, fonts, layout, and hero content live with the WordPress Customizer.</p>
</div>
<div class="wp-block-column">
<h4>&#128241; Mobile-First</h4>
<p>Pixel-perfect on every device, built with Bootstrap\'s responsive grid from the ground up.</p>
</div>
</div>
<!-- /wp:columns -->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator -->

<!-- wp:html -->
<div class="alert alert-info" role="alert"><strong>Tip:</strong> Install the free <a href="/wp-admin/plugin-install.php?s=wisebones-shortcodes">WiseBones Shortcodes</a> companion plugin to unlock 17 Bootstrap shortcodes and see the full demo.</div>
<!-- /wp:html -->

<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="has-text-align-center">Theme Features</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><li>Full Bootstrap 5.3 integration with local vendor assets</li><li>22 template files covering the complete WordPress template hierarchy</li><li>7 Customizer sections with live preview</li><li>Admin Options page — 19 general + 5 performance toggles</li><li>Per-post meta boxes for layout, hero image, and title visibility</li><li>Open Graph, Twitter Card, and Schema.org SEO module</li><li>WooCommerce compatibility layer</li><li>AJAX load-more and live search</li><li>Block editor support with theme.json</li><li>Translation-ready (.pot included)</li></ul>
<!-- /wp:list -->
';
    }

    $page_id = wp_insert_post( [
        'post_title'   => 'Home',
        'post_name'    => 'home',
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'meta_input'   => [ '_wpb_demo' => 1 ],
    ] );

    if ( ! is_wp_error( $page_id ) && ! empty( $image_ids[0] ) ) {
        set_post_thumbnail( $page_id, $image_ids[0] );
    }

    return is_wp_error( $page_id ) ? 0 : $page_id;
}

/* ── About page ─────────────────────────────────────────────── */

function wpb_demo_create_about_page( array $image_ids ): int {
    $has_sc = defined( 'WPBS_VERSION' );

    $badges = $has_sc
        ? '[wpb_badge color="primary" pill="true"]Bootstrap 5[/wpb_badge] [wpb_badge color="success" pill="true"]WooCommerce[/wpb_badge] [wpb_badge color="info" pill="true"]GPL Free[/wpb_badge] [wpb_badge color="secondary" pill="true"]PHP 8+[/wpb_badge]'
        : '<span class="badge bg-primary rounded-pill">Bootstrap 5</span> <span class="badge bg-success rounded-pill">WooCommerce</span> <span class="badge bg-info rounded-pill">GPL Free</span>';

    $content = '
<!-- wp:heading -->
<h2>About WPWiseBones</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>WPWiseBones is a comprehensive, production-ready Bootstrap 5 WordPress starter theme built for developers and agencies who need a solid foundation without the bloat. Every feature is included out of the box — from a full admin options panel to WooCommerce support, custom widgets, and a complete SEO module.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Built and maintained by <a href="https://wprealwise.com">WPRealWise</a> — real estate tools for the invested realtor. Our themes are used by agencies worldwide and follow strict WordPress.org coding standards.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<p style="margin:16px 0">' . $badges . '</p>
<!-- /wp:html -->

<!-- wp:heading {"level":3} -->
<h3>Our Design Philosophy</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We believe a starter theme should give you everything you need without constraining how you build. WPWiseBones ships with Bootstrap 5.3 fully integrated — with a local vendor option for strict CSP policies — and a complete set of WordPress hooks so you can extend anything without modifying core files.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3>What\'s Included</h3>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns">
<div class="wp-block-column">
<!-- wp:heading {"level":4} -->
<h4>&#128196; Templates</h4>
<!-- /wp:heading -->
<!-- wp:list -->
<ul><li>22 template files</li><li>Full WP template hierarchy</li><li>Custom page layouts via meta boxes</li><li>Hero banner on front page</li></ul>
<!-- /wp:list -->
</div>
<div class="wp-block-column">
<!-- wp:heading {"level":4} -->
<h4>&#9881; Admin</h4>
<!-- /wp:heading -->
<!-- wp:list -->
<ul><li>Theme Options page</li><li>19 general settings</li><li>5 performance toggles</li><li>Dashboard welcome widget</li></ul>
<!-- /wp:list -->
</div>
<div class="wp-block-column">
<!-- wp:heading {"level":4} -->
<h4>&#128269; Developer</h4>
<!-- /wp:heading -->
<!-- wp:list -->
<ul><li>WooCommerce compatible</li><li>Translation-ready</li><li>npm build scripts</li><li>20-check preflight suite</li></ul>
<!-- /wp:list -->
</div>
</div>
<!-- /wp:columns -->
';

    $page_id = wp_insert_post( [
        'post_title'   => 'About',
        'post_name'    => 'about',
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'meta_input'   => [ '_wpb_demo' => 1 ],
    ] );

    if ( ! is_wp_error( $page_id ) && ! empty( $image_ids[1] ) ) {
        set_post_thumbnail( $page_id, $image_ids[1] );
    }

    return is_wp_error( $page_id ) ? 0 : $page_id;
}

/* ── Blog page ───────────────────────────────────────────────── */

function wpb_demo_create_blog_page(): int {
    $page_id = wp_insert_post( [
        'post_title'   => 'Blog',
        'post_name'    => 'blog',
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'meta_input'   => [ '_wpb_demo' => 1 ],
    ] );

    return is_wp_error( $page_id ) ? 0 : $page_id;
}

/* ── Contact page ────────────────────────────────────────────── */

function wpb_demo_create_contact_page(): int {
    $has_sc  = defined( 'WPBS_VERSION' );
    $contact = $has_sc
        ? '[wpb_contact_info phone="+1 (555) 012-3456" email="hello@wprealwise.com" address="123 Main Street, New York, NY 10001" hours="Mon–Fri 9am–5pm EST"]'
        : '<ul class="list-unstyled"><li><i class="bi bi-telephone me-2"></i>+1 (555) 012-3456</li><li><i class="bi bi-envelope me-2"></i>hello@wprealwise.com</li><li><i class="bi bi-geo-alt me-2"></i>123 Main Street, New York, NY 10001</li></ul>';

    $content = '
<!-- wp:heading -->
<h2>Get in Touch</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Have a question about WPWiseBones or need help getting started? We\'d love to hear from you. Fill out the form below or reach us directly using the contact information on this page.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":"3rem"}}} -->
<div class="wp-block-columns">
<div class="wp-block-column" style="flex-basis:60%">

<!-- wp:heading {"level":3} -->
<h3>Send a Message</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><em>Add a contact form plugin here — WPForms, Contact Form 7, or Gravity Forms all work perfectly with WPWiseBones.</em></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<div class="alert alert-info">
  <i class="bi bi-info-circle me-2"></i>
  This is a demo contact page. Replace this notice with your preferred contact form plugin.
</div>
<!-- /wp:html -->

</div>
<div class="wp-block-column" style="flex-basis:40%">

<!-- wp:heading {"level":3} -->
<h3>Contact Details</h3>
<!-- /wp:heading -->

<!-- wp:html -->
' . $contact . '
<!-- /wp:html -->

<!-- wp:heading {"level":4} -->
<h4>Follow Us</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>
<a href="https://wprealwise.com" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary btn-sm me-2">
  <i class="bi bi-globe me-1"></i>Website
</a>
</p>
<!-- /wp:paragraph -->

</div>
</div>
<!-- /wp:columns -->
';

    $page_id = wp_insert_post( [
        'post_title'   => 'Contact',
        'post_name'    => 'contact',
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'meta_input'   => [ '_wpb_demo' => 1 ],
    ] );

    return is_wp_error( $page_id ) ? 0 : $page_id;
}

/* ── Sample posts ────────────────────────────────────────────── */

function wpb_demo_create_posts( int $cat_id, array $image_ids ): void {
    $posts = [
        [
            'title'   => 'Getting Started with WPWiseBones',
            'excerpt' => 'Everything you need to know to hit the ground running with the WPWiseBones theme.',
            'img_idx' => 2,
            'content' => '<!-- wp:paragraph --><p>WPWiseBones is designed to be the last starter theme you\'ll ever need. Whether you\'re building a portfolio, a business site, or a full e-commerce store, this theme has you covered right out of the box.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Installation</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Download the zip file from WordPress.org, upload it via <strong>Appearance → Themes → Add New → Upload Theme</strong>, and activate it. That\'s it. Your site will immediately look great with Bootstrap 5\'s clean default styles.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>First Steps</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Go to <strong>Appearance → Customize</strong> to set your colours and hero content</li><li>Visit <strong>Appearance → Theme Options</strong> for advanced settings</li><li>Install the WiseBones Shortcodes companion plugin for Bootstrap shortcodes</li><li>Set up your menus under <strong>Appearance → Menus</strong></li></ul><!-- /wp:list --><!-- wp:paragraph --><p>The theme is built with developers in mind — every function is prefixed, every hook is documented, and the code is organised into logical files under <code>inc/</code> so you\'ll always know where to find things.</p><!-- /wp:paragraph -->',
        ],
        [
            'title'   => 'Customising Your Theme with the WordPress Customizer',
            'excerpt' => 'A deep dive into the 7 Customizer sections and 18 settings available in WPWiseBones.',
            'img_idx' => 3,
            'content' => '<!-- wp:paragraph --><p>WPWiseBones ships with a comprehensive Customizer setup — 7 sections, 18 settings, and live preview for colours, hero content, and font size. No reloading, no guessing — what you see is what you get.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Sections Overview</h3><!-- /wp:heading --><!-- wp:list --><ul><li><strong>Header</strong> — sticky toggle, light/dark scheme, top bar</li><li><strong>Layout</strong> — sidebar position (left/right/none), container width</li><li><strong>Hero / Banner</strong> — heading, subheading, CTA button text and URL (live postMessage preview)</li><li><strong>Footer</strong> — copyright text, widget columns, back-to-top toggle</li><li><strong>Brand Colours</strong> — primary, secondary, accent, header background, footer background (live preview)</li><li><strong>Typography</strong> — body font, heading font via Google Fonts, base font size (live preview)</li><li><strong>Social Links</strong> — 8 networks including Facebook, Instagram, LinkedIn, and TikTok</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Settings that use <code>postMessage</code> transport update the preview frame instantly as you type — no save-reload cycle required. Settings using <code>refresh</code> trigger a fast selective refresh of just the affected component.</p><!-- /wp:paragraph -->',
        ],
        [
            'title'   => 'WooCommerce Integration — Bootstrap 5 Shop',
            'excerpt' => 'How WPWiseBones wraps WooCommerce in a clean Bootstrap 5 layout without any configuration.',
            'img_idx' => 4,
            'content' => '<!-- wp:paragraph --><p>WPWiseBones includes a full WooCommerce compatibility layer that works automatically the moment you activate WooCommerce. The shop, product, cart, and checkout pages all use Bootstrap 5 layouts with styled buttons, notices, and pagination.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>What\'s Included</h3><!-- /wp:heading --><!-- wp:list --><ul><li><code>add_theme_support(\'woocommerce\')</code> with product gallery zoom, lightbox, and slider</li><li>Bootstrap container + row wrapper replaces WooCommerce\'s default wrapper</li><li>Shop sidebar (<strong>Widgets → Shop Sidebar</strong>) with dynamic col width — full width when empty</li><li>Bootstrap-styled add-to-cart buttons using <code>--bs-primary</code> CSS variable</li><li>Bootstrap alerts for success, error, and info notices</li><li>Bootstrap Icons in pagination arrows</li><li>Template overrides: product card grid, loop start/end</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>No configuration required — install WooCommerce, create your products, and the shop will look great immediately.</p><!-- /wp:paragraph -->',
        ],
        [
            'title'   => 'The 17 Bootstrap Shortcodes — Full Reference',
            'excerpt' => 'A complete guide to every shortcode included in the WiseBones Shortcodes companion plugin.',
            'img_idx' => 5,
            'content' => '<!-- wp:paragraph --><p>The WiseBones Shortcodes companion plugin adds 17 Bootstrap 5 shortcodes to your WordPress site. Per WordPress.org guidelines, shortcodes live in a plugin rather than the theme — which means they work with any theme, not just WPWiseBones.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Content Shortcodes</h3><!-- /wp:heading --><!-- wp:list --><ul><li><code>[wpb_alert]</code> — Dismissible Bootstrap alert in success, danger, warning, or info style</li><li><code>[wpb_card]</code> — Bootstrap card with image, title, body, and optional button</li><li><code>[wpb_badge]</code> — Inline Bootstrap badge or pill label</li><li><code>[wpb_divider]</code> — Styled horizontal rule with optional centred text</li></ul><!-- /wp:list --><!-- wp:heading {"level":3} --><h3>Layout Shortcodes</h3><!-- /wp:heading --><!-- wp:list --><ul><li><code>[wpb_row]</code> / <code>[wpb_col]</code> — Full 12-column Bootstrap responsive grid</li><li><code>[wpb_tabs]</code> / <code>[wpb_tab]</code> — Tabbed content (tabs, pills, or underline style)</li><li><code>[wpb_accordion]</code> / <code>[wpb_accordion_item]</code> — Collapsible FAQ accordion</li><li><code>[wpb_modal]</code> — Bootstrap modal popup with trigger button</li></ul><!-- /wp:list --><!-- wp:heading {"level":3} --><h3>Marketing Shortcodes</h3><!-- /wp:heading --><!-- wp:list --><ul><li><code>[wpb_cta]</code> — Call-to-action banner with gradient background and dual buttons</li><li><code>[wpb_icon_box]</code> — Icon + heading + text feature box using Bootstrap Icons</li><li><code>[wpb_testimonial]</code> — Star-rated testimonial with author, role, and optional avatar</li><li><code>[wpb_countdown]</code> — Live JavaScript countdown timer to any date</li><li><code>[wpb_progress]</code> — Animated progress bar with label and colour variant</li><li><code>[wpb_posts]</code> — Bootstrap card grid of posts from a custom WP_Query</li><li><code>[wpb_map]</code> — Responsive iframe map embed</li><li><code>[wpb_contact_info]</code> — Contact info list with Bootstrap Icons</li></ul><!-- /wp:list -->',
        ],
        [
            'title'   => 'Admin Options — 24 Settings Explained',
            'excerpt' => 'A walkthrough of every setting in Appearance → Theme Options and what it controls.',
            'img_idx' => 6,
            'content' => '<!-- wp:paragraph --><p>WPWiseBones ships with a comprehensive Theme Options page under <strong>Appearance → Theme Options</strong>. Settings are split into two tabs — General and Performance — covering everything from the copyright text to script deferral.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>General Settings (19)</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Preloader — show/hide animated loading screen</li><li>Smooth scroll — native CSS smooth scrolling</li><li>Back-to-top button — floating scroll-to-top arrow</li><li>Breadcrumbs — automatic breadcrumb trail on all pages</li><li>Author box — display author bio on single posts</li><li>Related posts — grid of related posts below content</li><li>Reading time — estimated read time in post meta</li><li>Social share buttons — share links on single posts</li><li>Posts per page — override WordPress reading setting</li><li>Excerpt length — word count for archive excerpts</li><li>Copyright text — footer copyright with HTML support</li><li>Custom CSS — additional CSS injected in &lt;head&gt;</li><li>Custom JS (head) — scripts injected before &lt;/head&gt;</li><li>Custom JS (footer) — scripts injected before &lt;/body&gt;</li></ul><!-- /wp:list --><!-- wp:heading {"level":3} --><h3>Performance Settings (5)</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Disable emoji — removes WordPress emoji scripts and styles</li><li>Disable XML-RPC — completely disables the XML-RPC endpoint</li><li>Remove version strings — strips ?ver= from asset URLs</li><li>Disable embeds — removes the oEmbed discovery and data parse filter</li><li>Defer scripts — adds <code>defer</code> attribute to non-essential scripts</li></ul><!-- /wp:list -->',
        ],
        [
            'title'   => 'Building a Child Theme for WPWiseBones',
            'excerpt' => 'Step-by-step guide to creating a WPWiseBones child theme for safe customisation.',
            'img_idx' => 1,
            'content' => '<!-- wp:paragraph --><p>A child theme lets you customise WPWiseBones without losing your changes when the parent theme updates. It\'s the recommended way to make any modifications beyond what the Customizer and Theme Options cover.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Step 1 — Create the Folder</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Create a new folder in <code>wp-content/themes/</code> named <code>wpwisebones-child</code>.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Step 2 — style.css</h3><!-- /wp:heading --><!-- wp:code --><pre class="wp-block-code"><code>/*\nTheme Name:  WPWiseBones Child\nTemplate:    wpwisebones\nVersion:     1.0.0\nText Domain: wpwisebones-child\n*/</code></pre><!-- /wp:code --><!-- wp:heading {"level":3} --><h3>Step 3 — functions.php</h3><!-- /wp:heading --><!-- wp:code --><pre class="wp-block-code"><code>&lt;?php\nadd_action( \'wp_enqueue_scripts\', function() {\n    wp_enqueue_style(\n        \'wpwisebones-child-style\',\n        get_stylesheet_uri(),\n        [ \'wpb-main\' ],\n        \'1.0.0\'\n    );\n} );</code></pre><!-- /wp:code --><!-- wp:paragraph --><p>That\'s it! Activate your child theme and you can now safely override any parent template by copying it to your child theme folder and editing it there.</p><!-- /wp:paragraph -->',
        ],
    ];

    foreach ( $posts as $data ) {
        $post_id = wp_insert_post( [
            'post_title'    => $data['title'],
            'post_excerpt'  => $data['excerpt'],
            'post_content'  => $data['content'],
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_category' => [ $cat_id ],
            'meta_input'    => [ '_wpb_demo' => 1 ],
        ] );

        if ( ! is_wp_error( $post_id ) && ! empty( $image_ids[ $data['img_idx'] ] ) ) {
            set_post_thumbnail( $post_id, $image_ids[ $data['img_idx'] ] );
        }
    }
}

/* ── Nav menu ────────────────────────────────────────────────── */

function wpb_demo_create_menu( int $home_id, int $about_id, int $blog_id, int $contact_id ): void {
    $menu_name = 'WPWiseBones Demo Menu';
    $existing  = wp_get_nav_menu_object( $menu_name );

    if ( $existing ) {
        wp_delete_nav_menu( $existing->term_id );
    }

    $menu_id = wp_create_nav_menu( $menu_name );
    if ( is_wp_error( $menu_id ) ) {
        return;
    }

    $pages = [
        [ 'title' => 'Home',    'id' => $home_id ],
        [ 'title' => 'About',   'id' => $about_id ],
        [ 'title' => 'Blog',    'id' => $blog_id ],
        [ 'title' => 'Contact', 'id' => $contact_id ],
    ];

    foreach ( $pages as $page ) {
        if ( ! $page['id'] ) {
            continue;
        }
        wp_update_nav_menu_item( $menu_id, 0, [
            'menu-item-title'     => $page['title'],
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $page['id'],
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
    }

    // Assign to primary location
    $locations = get_theme_mod( 'nav_menu_locations', [] );
    $locations['primary'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );
}

/* ── Customizer settings ─────────────────────────────────────── */

function wpb_demo_set_customizer(): void {
    set_theme_mod( 'wpb_hero_heading',    'Build Beautiful WordPress Sites' );
    set_theme_mod( 'wpb_hero_subheading', 'WPWiseBones — Bootstrap 5 · 22 Templates · 17 Shortcodes · WooCommerce Ready' );
    set_theme_mod( 'wpb_hero_btn_text',   'Explore Demo' );
    set_theme_mod( 'wpb_hero_btn_url',    '/blog' );
    set_theme_mod( 'wpb_sticky_header',   true );
    set_theme_mod( 'wpb_color_primary',   '#0d6efd' );
    set_theme_mod( 'wpb_color_accent',    '#6610f2' );
    set_theme_mod( 'wpb_footer_copyright', 'WPWiseBones Demo &mdash; Built with Bootstrap 5 by <a href="https://wprealwise.com" target="_blank" rel="noopener noreferrer">WPRealWise</a>.' );

    $wpb_options = get_option( 'wpb_options', [] );
    $wpb_options['back_to_top']   = '1';
    $wpb_options['smooth_scroll'] = '1';
    $wpb_options['breadcrumbs']   = '1';
    $wpb_options['reading_time']  = '1';
    update_option( 'wpb_options', $wpb_options );
}

/* ── Widgets ─────────────────────────────────────────────────── */

function wpb_demo_setup_widgets(): void {
    $sidebars = get_option( 'sidebars_widgets', [] );

    // Primary sidebar
    $sidebars['sidebar-1'] = [
        'search-2',
        'recent-posts-2',
        'categories-2',
        'tag_cloud-2',
    ];

    // Footer col 1
    $sidebars['footer-1'] = [ 'text-2' ];

    // Footer col 2
    $sidebars['footer-2'] = [ 'recent-posts-3' ];

    // Footer col 3
    $sidebars['footer-3'] = [ 'categories-3' ];

    update_option( 'sidebars_widgets', $sidebars );

    // About text widget
    update_option( 'widget_text', [
        2 => [
            'title'  => 'About WPWiseBones',
            'text'   => 'A production-ready Bootstrap 5 WordPress starter theme. Built by <a href="https://wprealwise.com">WPRealWise</a>.',
            'filter' => false,
            'visual' => false,
        ],
        '_multiwidget' => 1,
    ] );

    // Recent posts widgets
    update_option( 'widget_recent-posts', [
        2 => [ 'title' => 'Latest Posts',    'number' => 5, 'show_date' => true ],
        3 => [ 'title' => 'Recent Articles', 'number' => 3, 'show_date' => false ],
        '_multiwidget' => 1,
    ] );

    // Categories widgets
    update_option( 'widget_categories', [
        2 => [ 'title' => 'Categories', 'count' => true, 'hierarchical' => false, 'dropdown' => false ],
        3 => [ 'title' => 'Topics',     'count' => false, 'hierarchical' => false, 'dropdown' => false ],
        '_multiwidget' => 1,
    ] );
}

/* ═══════════════════════════════════════════════════════════════
   RESET
   ═══════════════════════════════════════════════════════════════ */

function wpb_demo_reset(): void {
    // Remove demo posts and pages
    $items = get_posts( [
        'post_type'      => [ 'post', 'page', 'attachment' ],
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'meta_key'       => '_wpb_demo',
        'meta_value'     => 1,
        'fields'         => 'ids',
    ] );

    foreach ( $items as $id ) {
        wp_delete_post( $id, true );
    }

    // Remove demo nav menu
    $menu = wp_get_nav_menu_object( 'WPWiseBones Demo Menu' );
    if ( $menu ) {
        wp_delete_nav_menu( $menu->term_id );
    }

    // Remove demo category
    $cat = get_term_by( 'slug', 'wpb-demo', 'category' );
    if ( $cat ) {
        wp_delete_term( $cat->term_id, 'category' );
    }

    // Reset reading settings
    update_option( 'show_on_front',  'posts' );
    delete_option( 'page_on_front' );
    delete_option( 'page_for_posts' );

    // Remove customizer mods set by demo
    remove_theme_mod( 'wpb_hero_heading' );
    remove_theme_mod( 'wpb_hero_subheading' );
    remove_theme_mod( 'wpb_hero_btn_text' );
    remove_theme_mod( 'wpb_hero_btn_url' );
    remove_theme_mod( 'wpb_footer_copyright' );

    // Clear demo flag
    delete_option( 'wpb_demo_installed' );
}
