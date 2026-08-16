<?php
/**
 * RealWise one-click demo importer (Easy Digital Downloads storefront).
 *
 * Appearance → RealWise Demo → Import. Builds the full portfolio site:
 *   • Pages: Home, Features, Pricing, Docs, About, Contact, Blog
 *   • Static front page (Home) + posts page (Blog) + a sample post
 *   • Primary + footer nav menus, assigned to their locations
 *   • Hero / brand theme-mods
 *   • EDD storefront (if Easy Digital Downloads is active): two downloads —
 *     RealWise (free, $0) and RealWise MLS ($149/yr). The real plugin zips
 *     bundled in this theme are copied into a protected uploads folder and
 *     attached. If EDD Software Licensing is active, the MLS download is marked
 *     license-enabled so it issues the keys the RealWise MLS plugin validates.
 *
 * Idempotent: pages/downloads are matched by a meta flag and updated in place.
 */

defined( 'ABSPATH' ) || exit;

const REALWISE_DEMO_FLAG = '_realwise_demo_slug';

/* ── Admin page ───────────────────────────────────────────────────────── */

add_action( 'admin_menu', function () {
    add_theme_page(
        __( 'Import RealWise Demo', 'realwise' ),
        __( 'RealWise Demo', 'realwise' ),
        'manage_options',
        'realwise-demo',
        'realwise_demo_render_page'
    );
} );

function realwise_demo_render_page() {
    $done    = get_option( 'realwise_demo_imported' );
    $edd     = class_exists( 'Easy_Digital_Downloads' );
    $edd_sl  = class_exists( 'EDD_Software_Licensing' );
    $sc      = defined( 'WPBS_VERSION' );
    $run_url = wp_nonce_url( admin_url( 'admin-post.php?action=realwise_import_demo' ), 'realwise_import_demo' );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'RealWise — Demo Content Importer', 'realwise' ); ?>
            <span class="title-count" style="vertical-align:middle"><?php echo esc_html( 'v' . ( defined( 'REALWISE_VERSION' ) ? REALWISE_VERSION : '' ) ); ?></span>
        </h1>
        <p class="description" style="max-width:680px">
            <?php esc_html_e( 'One click builds the entire RealWise site: Home, Features, Pricing, Docs, About, Contact and Blog pages, the menus, the hero, and (with Easy Digital Downloads) the storefront. Safe to run more than once — existing demo content is updated, not duplicated.', 'realwise' ); ?>
        </p>

        <h2 class="title"><?php esc_html_e( 'Prerequisites', 'realwise' ); ?></h2>
        <ul style="list-style:disc;margin-left:20px">
            <li><?php echo $sc
                ? '✅ ' . esc_html__( 'WiseBones Shortcodes active — rich page blocks will render.', 'realwise' )
                : '⚠️ ' . esc_html__( 'WiseBones Shortcodes is NOT active — pages import, but [wpb_*] blocks show as raw text until you activate it.', 'realwise' ); ?></li>
            <li><?php echo $edd
                ? '✅ ' . esc_html__( 'Easy Digital Downloads active — the RealWise and RealWise MLS downloads will be created.', 'realwise' )
                : 'ℹ️ ' . esc_html__( 'Easy Digital Downloads not active — storefront downloads are skipped (everything else still imports).', 'realwise' ); ?></li>
            <li><?php echo $edd_sl
                ? '✅ ' . esc_html__( 'EDD Software Licensing active — RealWise MLS will be license-enabled (issues keys the plugin validates).', 'realwise' )
                : 'ℹ️ ' . esc_html__( 'EDD Software Licensing not detected — the MLS download is created, but enable Software Licensing to sell license keys.', 'realwise' ); ?></li>
        </ul>

        <?php if ( $done ) : ?>
            <div class="notice notice-success inline"><p>
                <?php
                printf(
                    /* translators: %s is a date/time. */
                    esc_html__( 'Demo content was last imported on %s. Running again refreshes it in place.', 'realwise' ),
                    esc_html( get_date_from_gmt( gmdate( 'Y-m-d H:i:s', (int) $done ), get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) )
                );
                ?>
            </p></div>
        <?php endif; ?>

        <p style="margin-top:1.5rem">
            <a href="<?php echo esc_url( $run_url ); ?>" class="button button-primary button-hero">
                <?php echo $done ? esc_html__( 'Re-import / Refresh Demo Content', 'realwise' ) : esc_html__( 'Import RealWise Demo Content', 'realwise' ); ?>
            </a>
        </p>
    </div>
    <?php
}

/* ── Import handler ───────────────────────────────────────────────────── */

/**
 * Run the full import. Shared by the activation hook and the admin button.
 * Returns the storefront status message.
 */
function realwise_run_demo_import(): string {
    // Storefront first, so the pages can embed [purchase_link id="…"].
    $downloads = realwise_demo_downloads();

    $pages = realwise_demo_pages( $downloads );
    $ids   = [];
    foreach ( $pages as $slug => $page ) {
        $ids[ $slug ] = realwise_demo_upsert_page( $slug, $page['title'], $page['content'], $page['template'] ?? '' );
    }

    // Static front page (so Blog can be the posts page). front-page.php still
    // controls how the homepage renders.
    if ( ! empty( $ids['home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', (int) $ids['home'] );
    }
    if ( ! empty( $ids['blog'] ) ) {
        update_option( 'page_for_posts', (int) $ids['blog'] );
    }

    realwise_demo_sample_post();
    realwise_demo_menus( $ids );
    realwise_demo_theme_mods( $ids );
    realwise_demo_site_icon();

    update_option( 'realwise_demo_imported', time() );

    return $downloads['msg'];
}

/** Set the browser-tab Site Icon from the bundled favicon (once). */
function realwise_demo_site_icon(): void {
    if ( get_option( 'site_icon' ) ) {
        return;
    }
    $src = get_stylesheet_directory() . '/assets/images/favicon.png';
    if ( ! file_exists( $src ) ) {
        return;
    }
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $up   = wp_upload_dir();
    $dest = trailingslashit( $up['path'] ) . 'realwise-site-icon.png';
    if ( ! copy( $src, $dest ) ) { // phpcs:ignore
        return;
    }
    $attach_id = wp_insert_attachment( [
        'post_mime_type' => 'image/png',
        'post_title'     => 'RealWise Site Icon',
        'post_status'    => 'inherit',
    ], $dest );
    if ( ! $attach_id || is_wp_error( $attach_id ) ) {
        return;
    }
    wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $dest ) );
    update_option( 'site_icon', (int) $attach_id );
}

/* Auto-build the site the first time the theme is activated. */
add_action( 'after_switch_theme', function () {
    if ( get_option( 'realwise_demo_imported' ) ) {
        return; // already built — never clobber an existing site
    }
    realwise_run_demo_import();
} );

add_action( 'admin_post_realwise_import_demo', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Insufficient permissions.', 'realwise' ) );
    }
    check_admin_referer( 'realwise_import_demo' );

    $msg = realwise_run_demo_import();

    wp_safe_redirect( add_query_arg(
        [ 'page' => 'realwise-demo', 'imported' => 1, 'msg' => rawurlencode( $msg ) ],
        admin_url( 'themes.php' )
    ) );
    exit;
} );

add_action( 'admin_notices', function () {
    if ( ! isset( $_GET['imported'], $_GET['page'] ) || 'realwise-demo' !== $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return;
    }
    $msg = isset( $_GET['msg'] ) ? sanitize_text_field( wp_unslash( $_GET['msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    echo '<div class="notice notice-success is-dismissible"><p><strong>'
        . esc_html__( 'RealWise demo imported.', 'realwise' ) . '</strong> '
        . esc_html__( 'Visit your site to see the new front page.', 'realwise' )
        . ( $msg ? ' ' . esc_html( $msg ) : '' )
        . '</p></div>';
} );

/* ── Page upsert (idempotent by meta flag) ────────────────────────────── */

function realwise_demo_upsert_page( string $slug, string $title, string $content, string $template = '' ): int {
    $existing = get_posts( [
        'post_type'   => 'page',
        'post_status' => 'any',
        'numberposts' => 1,
        'meta_key'    => REALWISE_DEMO_FLAG,
        'meta_value'  => $slug,
        'fields'      => 'ids',
    ] );

    $data = [
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
    ];
    if ( $existing ) {
        $data['ID'] = (int) $existing[0];
        $id = wp_update_post( $data );
    } else {
        $id = wp_insert_post( $data );
    }
    $id = (int) $id;
    if ( $id ) {
        update_post_meta( $id, REALWISE_DEMO_FLAG, $slug );
        if ( $template ) {
            update_post_meta( $id, '_wp_page_template', $template );
        }
    }
    return $id;
}

/* ── EDD downloads (the storefront) ───────────────────────────────────── */

/** Copy a bundled plugin zip into a protected uploads dir; return its URL. */
function realwise_copy_download( string $filename ): string {
    $src = get_stylesheet_directory() . '/downloads/' . $filename;
    if ( ! file_exists( $src ) ) {
        return '';
    }
    $up  = wp_upload_dir();
    $dir = trailingslashit( $up['basedir'] ) . 'edd';   // EDD's protected folder
    if ( ! file_exists( $dir ) ) {
        wp_mkdir_p( $dir );
    }
    // Make sure direct HTTP access is blocked (EDD serves via its download handler).
    if ( ! file_exists( $dir . '/.htaccess' ) ) {
        file_put_contents( $dir . '/.htaccess', "Options -Indexes\ndeny from all\n" ); // phpcs:ignore
    }
    if ( ! file_exists( $dir . '/index.php' ) ) {
        file_put_contents( $dir . '/index.php', "<?php // Silence is golden.\n" ); // phpcs:ignore
    }
    $dest = $dir . '/' . $filename;
    if ( ! file_exists( $dest ) || filesize( $dest ) !== filesize( $src ) ) {
        copy( $src, $dest ); // phpcs:ignore
    }
    return trailingslashit( $up['baseurl'] ) . 'edd/' . $filename;
}

/**
 * Create/refresh the two EDD downloads. Returns [ free, mls, msg ].
 */
function realwise_demo_downloads(): array {
    $out = [ 'free' => 0, 'mls' => 0, 'msg' => '' ];

    if ( ! post_type_exists( 'download' ) ) { // EDD registers the 'download' CPT
        $out['msg'] = __( 'Easy Digital Downloads not active — downloads skipped.', 'realwise' );
        return $out;
    }

    $upsert = function ( string $flag, string $title, string $content, string $price, string $zip, bool $licensed ) {
        $existing = get_posts( [
            'post_type'   => 'download',
            'post_status' => 'any',
            'numberposts' => 1,
            'meta_key'    => REALWISE_DEMO_FLAG,
            'meta_value'  => $flag,
            'fields'      => 'ids',
        ] );
        $data = [
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'download',
        ];
        if ( $existing ) {
            $data['ID'] = (int) $existing[0];
            $id = (int) wp_update_post( $data );
        } else {
            $id = (int) wp_insert_post( $data );
        }
        if ( ! $id ) {
            return 0;
        }
        update_post_meta( $id, REALWISE_DEMO_FLAG, $flag );

        // Price (simple, non-variable).
        update_post_meta( $id, 'edd_price', number_format( (float) $price, 2, '.', '' ) );
        update_post_meta( $id, '_variable_pricing', 0 );
        update_post_meta( $id, '_edd_button_behavior', 'add_to_cart' );

        // Attach the real plugin zip.
        $url = realwise_copy_download( $zip );
        if ( $url ) {
            update_post_meta( $id, 'edd_download_files', [
                [ 'index' => 0, 'attachment_id' => 0, 'name' => $zip, 'file' => $url, 'condition' => 'all' ],
            ] );
        }

        // Software Licensing for the commercial product (only if the add-on is active).
        if ( $licensed && class_exists( 'EDD_Software_Licensing' ) ) {
            update_post_meta( $id, '_edd_sl_enabled',    1 );
            update_post_meta( $id, '_edd_sl_version',    '1.0.0' );
            update_post_meta( $id, '_edd_sl_limit',      1 );        // one site per license
            update_post_meta( $id, '_edd_sl_exp_unit',   'years' );
            update_post_meta( $id, '_edd_sl_exp_length', 1 );        // 1-year license
        }
        return $id;
    };

    $out['free'] = $upsert(
        'dl-free',
        __( 'RealWise', 'realwise' ),
        '<p>The free real-estate platform plugin: listings &amp; search, investor proformas, CRM, agent portal, property management and tours — all in one plugin. Pair it with RealWise MLS to automate listing imports.</p>',
        '0',
        'realwise.zip',
        false
    );

    // NOTE: title MUST stay "RealWise MLS" — the plugin's licensing/updater sends
    // item_name="RealWise MLS" and EDD Software Licensing matches on it.
    $out['mls'] = $upsert(
        'dl-mls',
        'RealWise MLS',
        '<p>Automated MLS/IDX import for RealWise — RESO Web API plus presets for Bridge, Trestle, MLS Grid, Paragon, FlexMLS/Spark, SimplyRETS, ATTOM, Crexi and legacy RETS. Includes a one-year license with automatic updates and priority support. Requires the free RealWise plugin.</p>',
        '149',
        'realwise-mls.zip',
        true
    );

    $out['msg'] = __( 'Created the RealWise (free) and RealWise MLS downloads in EDD.', 'realwise' );
    return $out;
}

/* ── Menus ────────────────────────────────────────────────────────────── */

function realwise_demo_menus( array $ids ): void {
    $build = function ( string $name, array $items ) {
        $menu    = wp_get_nav_menu_object( $name );
        $menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );
        if ( is_wp_error( $menu_id ) || ! $menu_id ) {
            return 0;
        }
        foreach ( wp_get_nav_menu_items( $menu_id ) ?: [] as $item ) {
            wp_delete_post( $item->ID, true );
        }
        foreach ( $items as $item ) {
            if ( ! empty( $item['page_id'] ) ) {
                wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'     => $item['title'],
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => (int) $item['page_id'],
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                ] );
            } else {
                wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'  => $item['title'],
                    'menu-item-url'    => $item['url'],
                    'menu-item-type'   => 'custom',
                    'menu-item-status' => 'publish',
                ] );
            }
        }
        return $menu_id;
    };

    $primary = [
        [ 'title' => __( 'Home', 'realwise' ),     'page_id' => $ids['home']     ?? 0 ],
        [ 'title' => __( 'Features', 'realwise' ), 'page_id' => $ids['features'] ?? 0 ],
        [ 'title' => __( 'Pricing', 'realwise' ),  'page_id' => $ids['pricing']  ?? 0 ],
        [ 'title' => __( 'Store', 'realwise' ),    'page_id' => $ids['store']    ?? 0 ],
        [ 'title' => __( 'Docs', 'realwise' ),     'page_id' => $ids['docs']     ?? 0 ],
    ];
    $primary[] = [ 'title' => __( 'Blog', 'realwise' ),    'page_id' => $ids['blog']    ?? 0 ];
    $primary[] = [ 'title' => __( 'About', 'realwise' ),   'page_id' => $ids['about']   ?? 0 ];
    $primary[] = [ 'title' => __( 'Contact', 'realwise' ), 'page_id' => $ids['contact'] ?? 0 ];

    $primary_id = $build( 'RealWise Primary', $primary );
    $footer_id  = $build( 'RealWise Footer', [
        [ 'title' => __( 'Features', 'realwise' ), 'page_id' => $ids['features'] ?? 0 ],
        [ 'title' => __( 'Pricing', 'realwise' ),  'page_id' => $ids['pricing']  ?? 0 ],
        [ 'title' => __( 'Docs', 'realwise' ),     'page_id' => $ids['docs']     ?? 0 ],
        [ 'title' => __( 'About', 'realwise' ),    'page_id' => $ids['about']    ?? 0 ],
        [ 'title' => __( 'Contact', 'realwise' ),  'page_id' => $ids['contact']  ?? 0 ],
    ] );

    $locations = get_theme_mod( 'nav_menu_locations', [] );
    if ( $primary_id ) {
        $locations['primary'] = $primary_id;
        $locations['mobile']  = $primary_id;
    }
    if ( $footer_id ) {
        $locations['footer'] = $footer_id;
    }
    set_theme_mod( 'nav_menu_locations', $locations );
}

/* ── Theme mods (hero + brand) ────────────────────────────────────────── */

function realwise_demo_theme_mods( array $ids ): void {
    set_theme_mod( 'wpb_hero_heading',    __( 'The complete real-estate platform for WordPress', 'realwise' ) );
    set_theme_mod( 'wpb_hero_subheading', __( 'Listings & search, investor analytics, CRM, property management, tours and automated MLS imports — one platform, two plugins.', 'realwise' ) );
    set_theme_mod( 'wpb_hero_btn_text',   __( 'See pricing', 'realwise' ) );
    set_theme_mod( 'wpb_hero_btn_url',    ! empty( $ids['pricing'] ) ? get_permalink( (int) $ids['pricing'] ) : home_url( '/pricing/' ) );
    set_theme_mod( 'wpb_container_width', 'container' );
    set_theme_mod( 'wpb_sticky_header',   1 );
}

/* ── Sample blog post ─────────────────────────────────────────────────── */

function realwise_demo_sample_post(): void {
    $posts = [
        'welcome' => [
            __( 'Introducing RealWise: real estate, done right on WordPress', 'realwise' ),
            __( 'Why we put the whole real-estate lifecycle into one plugin.', 'realwise' ),
            "<p>Most real-estate sites are a patchwork: an IDX plugin for search, a separate CRM for leads, a SaaS for tours, and a spreadsheet for the numbers. None of them share data, each one bills monthly, and every WordPress update is a gamble.</p>\n<p><strong>RealWise</strong> brings the whole lifecycle into one free, GPL-licensed plugin — discover, import, underwrite, capture, operate, tour and manage — with a commercial MLS importer when you're ready to automate listing imports.</p>\n<p>Install it, drop two shortcodes on a page, and you have a working real-estate site in minutes. <a href=\"/pricing/\">See pricing &rarr;</a></p>",
        ],
        'investor-tools' => [
            __( 'Underwrite a deal in 60 seconds with the RealWise deal score', 'realwise' ),
            __( 'NPV, IRR, DSCR and cash-on-cash — without the spreadsheet.', 'realwise' ),
            "<p>Serious investors live in spreadsheets. RealWise replaces them. Enter a purchase price, rents and expenses, and the proforma returns NPV, IRR, DSCR and cash-on-cash instantly — plus an automated <em>deal score</em> that ranks the opportunity for you.</p>\n<p>The 28-item renovation estimator and fix-and-flip ARV analysis mean you can size a value-add play right on the listing page. <a href=\"/features/\">Explore investor tools &rarr;</a></p>",
        ],
        'automate-mls' => [
            __( 'Stop entering listings by hand: automate your MLS with RealWise MLS', 'realwise' ),
            __( 'Scheduled imports from RESO, FlexMLS/Spark, RETS, ATTOM, Crexi and more.', 'realwise' ),
            "<p>Manually copying listings is the worst part of running a real-estate site. <strong>RealWise MLS</strong> connects to your MLS and imports on a schedule — using the generic RESO Web API plus presets for Bridge, Trestle, MLS Grid, Paragon, FlexMLS/Spark, SimplyRETS, ATTOM, Crexi and legacy RETS.</p>\n<p>Map any non-standard fields, set a schedule, and walk away. No MLS yet? The free Demo adapter imports 24 sample listings so you can see the whole pipeline first. <a href=\"/store/\">Get RealWise MLS &rarr;</a></p>",
        ],
    ];

    foreach ( $posts as $slug => $p ) {
        $existing = get_posts( [
            'post_type'   => 'post',
            'post_status' => 'any',
            'numberposts' => 1,
            'fields'      => 'ids',
            'meta_key'    => REALWISE_DEMO_FLAG,
            'meta_value'  => $slug,
        ] );
        if ( $existing ) {
            continue;
        }
        $id = wp_insert_post( [
            'post_title'   => $p[0],
            'post_excerpt' => $p[1],
            'post_content' => $p[2],
            'post_status'  => 'publish',
            'post_type'    => 'post',
        ] );
        if ( $id && ! is_wp_error( $id ) ) {
            update_post_meta( (int) $id, REALWISE_DEMO_FLAG, $slug );
        }
    }
}

/* ── Page content ─────────────────────────────────────────────────────── */

/** A full-bleed brand section. */
function realwise_section( string $inner, string $mod = '', string $container = 'container' ): string {
    $cls = trim( 'rw-section ' . $mod );
    return "\n<section class=\"{$cls}\">\n  <div class=\"{$container}\">\n{$inner}\n  </div>\n</section>\n";
}

function realwise_demo_pages( array $dl = [] ): array {
    $tpl     = 'page-templates/marketing.php';
    $free_id = (int) ( $dl['free'] ?? 0 );
    $mls_id  = (int) ( $dl['mls']  ?? 0 );

    // EDD purchase buttons (fall back to a Store link when EDD is inactive).
    $buy_free = $free_id
        ? '[purchase_link id="' . $free_id . '" text="Download free" style="button" class="btn btn-outline-primary btn-lg"]'
        : '[wpb_button url="/downloads/" style="outline-primary" size="lg"]Download free[/wpb_button]';
    $buy_mls = $mls_id
        ? '[purchase_link id="' . $mls_id . '" text="Buy RealWise MLS — $149/yr" style="button" class="btn btn-success btn-lg"]'
        : '[wpb_button url="/downloads/" style="success" size="lg"]Buy RealWise MLS[/wpb_button]';

    /* ---------- HOME ---------- */
    $hero = '
<section class="wpb-hero text-center">
  <div class="container">
    <span class="badge rounded-pill bg-light text-dark mb-3">One platform · Two plugins</span>
    <h1 class="display-4 fw-bold mb-3">The complete real-estate platform for WordPress</h1>
    <p class="lead mb-4 opacity-90">Listings &amp; search, investor analytics, CRM, property management, tours and automated MLS imports — without stitching together a dozen plugins.</p>
    <div class="d-flex gap-2 justify-content-center flex-wrap">
      [wpb_button url="/pricing/" style="light" size="lg" icon="bi-tag"]See pricing[/wpb_button]
      [wpb_button url="/features/" style="outline-light" size="lg" icon="bi-grid"]Explore features[/wpb_button]
    </div>
  </div>
</section>';

    $features = '
    <div class="text-center mb-5"><span class="rw-eyebrow">Everything included</span><h2 class="mt-2">Six modules, one free plugin</h2></div>
    [wpb_row gutter="4"]
      [wpb_col lg="4" md="6"][wpb_icon_box icon="bi-house-door" title="Listings &amp; Search" color="success"]Map search, Walk Score / crime / school data, mortgage calculator, saved searches and email alerts.[/wpb_icon_box][/wpb_col]
      [wpb_col lg="4" md="6"][wpb_icon_box icon="bi-graph-up-arrow" title="Investor Tools" color="success"]Proformas with NPV / IRR / DSCR, a renovation estimator, fix-and-flip ARV and an automated deal score.[/wpb_icon_box][/wpb_col]
      [wpb_col lg="4" md="6"][wpb_icon_box icon="bi-people" title="CRM &amp; Leads" color="success"]A drag-and-drop pipeline with auto-capture, lead scoring, round-robin assignment and email drips.[/wpb_icon_box][/wpb_col]
      [wpb_col lg="4" md="6"][wpb_icon_box icon="bi-person-badge" title="Agent Portal" color="success"]A front-end, role-gated dashboard where agents manage their own listings, leads and profile.[/wpb_icon_box][/wpb_col]
      [wpb_col lg="4" md="6"][wpb_icon_box icon="bi-building" title="Property Management" color="success"]Leases, a tenant portal, online rent via Stripe, late fees and maintenance requests.[/wpb_icon_box][/wpb_col]
      [wpb_col lg="4" md="6"][wpb_icon_box icon="bi-calendar-check" title="Tours &amp; Scheduling" color="success"]Request-a-tour booking with availability windows, .ics invites and reminders that feed the CRM.[/wpb_icon_box][/wpb_col]
    [/wpb_row]';

    $products = '
    <div class="text-center mb-5"><span class="rw-eyebrow">How it ships</span><h2 class="mt-2">A free foundation, plus automated MLS</h2></div>
    [wpb_row gutter="4" valign="stretch"]
      [wpb_col lg="6"]<div class="rw-price"><h3 class="fw-bold">RealWise</h3><p class="text-muted">The complete platform · Free</p><div class="rw-price__amt">$0</div><p>The six modules above, in one free plugin.</p>' . $buy_free . '</div>[/wpb_col]
      [wpb_col lg="6"]<div class="rw-price rw-price--featured"><h3 class="fw-bold">RealWise MLS</h3><p class="text-muted">Automated MLS import</p><div class="rw-price__amt">$149 <span class="rw-price__per">/ yr</span></div><p>Scheduled imports from your MLS — RESO, FlexMLS/Spark, RETS, ATTOM, Crexi and more.</p>' . $buy_mls . '</div>[/wpb_col]
    [/wpb_row]';

    $social = '
    <div class="text-center mb-5"><span class="rw-eyebrow">Trusted by operators</span><h2 class="mt-2">Built for brokerages, investors &amp; managers</h2></div>
    [wpb_row gutter="4"]
      [wpb_col md="4"][wpb_testimonial author="Dana Reyes" role="Managing Broker" stars="5"]We replaced four plugins with RealWise. Listings, leads and tours finally live in one place.[/wpb_testimonial][/wpb_col]
      [wpb_col md="4"][wpb_testimonial author="Marcus Lee" role="Real-estate Investor" stars="5"]The proforma and deal score do in seconds what used to take a spreadsheet afternoon.[/wpb_testimonial][/wpb_col]
      [wpb_col md="4"][wpb_testimonial author="Priya N." role="Property Manager" stars="5"]Online rent, leases and maintenance — my tenants self-serve and I stopped chasing checks.[/wpb_testimonial][/wpb_col]
    [/wpb_row]';

    $cta = '[wpb_cta heading="Ready to put your real-estate business on autopilot?" subtext="Start free, then add automated MLS imports whenever you are ready." btn_text="See pricing" btn_url="/pricing/" btn_style="light" bg="gradient"]';

    $home = $hero
        . realwise_section( $features, 'rw-section--mist' )
        . realwise_section( $products )
        . realwise_section( $social, 'rw-section--mist' )
        . realwise_section( $cta );

    /* ---------- FEATURES ---------- */
    $features_page = realwise_section( '
    <div class="text-center mb-5" style="max-width:760px;margin-inline:auto"><span class="rw-eyebrow">Features</span><h2 class="mt-2">One platform for the entire deal lifecycle</h2><p class="text-muted mt-2">From the first search to the signed lease &mdash; every tool your real-estate business needs. Free in the RealWise plugin unless marked otherwise.</p></div>
    [wpb_tabs style="pills" fill="true"]
      [wpb_tab title="Listings" icon="bi-house-door" active="true"]<h3 class="h4 fw-bold">Listings &amp; Search</h3><p class="text-muted">The IDX experience buyers expect &mdash; fast, visual and data-rich.</p><ul><li>Map-based search with filters and saved searches</li><li>Walk Score, crime and school overlays</li><li>Built-in mortgage calculator &amp; comparable sales</li><li>Email alerts when new matches hit the market</li><li>REST API and shortcodes for any page or theme</li></ul>[/wpb_tab]
      [wpb_tab title="Investor" icon="bi-graph-up-arrow"]<h3 class="h4 fw-bold">Investor Tools</h3><p class="text-muted">Underwrite any property in under a minute.</p><ul><li>Full proforma: NPV, IRR, DSCR, cash-on-cash</li><li>28-item renovation cost estimator</li><li>Fix-and-flip ARV analysis</li><li>An automated deal score that ranks opportunities</li></ul>[/wpb_tab]
      [wpb_tab title="CRM" icon="bi-people"]<h3 class="h4 fw-bold">CRM &amp; Leads</h3><p class="text-muted">Never lose a lead in an inbox again.</p><ul><li>Drag-and-drop pipeline</li><li>Auto-capture from search, save and tour forms</li><li>Lead scoring &amp; round-robin assignment</li><li>Email (and optional SMS) drip sequences</li><li>One-click CSV export</li></ul>[/wpb_tab]
      [wpb_tab title="Operations" icon="bi-building"]<h3 class="h4 fw-bold">Property Management</h3><p class="text-muted">Run rentals without the busywork.</p><ul><li>Properties, units &amp; leases</li><li>Tenant portal with online rent via Stripe</li><li>Automatic late fees</li><li>Maintenance requests</li><li>An agent portal so staff never touch wp-admin</li></ul>[/wpb_tab]
      [wpb_tab title="Tours" icon="bi-calendar-check"]<h3 class="h4 fw-bold">Tours &amp; Scheduling</h3><p class="text-muted">Turn interest into booked showings.</p><ul><li>Request-a-tour booking with real availability</li><li>.ics calendar invites &amp; reminders</li><li>Every booking becomes a hot lead in the CRM</li></ul>[/wpb_tab]
      [wpb_tab title="MLS" icon="bi-arrow-repeat"]<h3 class="h4 fw-bold">RealWise MLS <span class="badge bg-success">Paid add-on</span></h3><p class="text-muted">Stop entering listings by hand.</p><ul><li>Generic RESO Web API + presets: Bridge, Trestle, MLS Grid, Paragon, FlexMLS/Spark, SimplyRETS, ATTOM, Crexi, legacy RETS</li><li>Scheduled imports &amp; field mapping</li><li>Import log, plus a free Demo adapter to try it</li></ul>[/wpb_tab]
    [/wpb_tabs]' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Everything included</span><h2 class="mt-2">A checklist of what you get &mdash; free</h2></div>
    [wpb_row gutter="4"]
      [wpb_col md="4"]<ul class="rw-check"><li>Map property search</li><li>Walk Score / crime / schools</li><li>Mortgage calculator</li><li>Saved searches + alerts</li><li>Comparable sales</li><li>REST API &amp; shortcodes</li></ul>[/wpb_col]
      [wpb_col md="4"]<ul class="rw-check"><li>NPV / IRR / DSCR proforma</li><li>Renovation estimator</li><li>Fix-and-flip ARV</li><li>Automated deal score</li><li>Lead pipeline &amp; scoring</li><li>Email drip sequences</li></ul>[/wpb_col]
      [wpb_col md="4"]<ul class="rw-check"><li>Front-end agent portal</li><li>Leases &amp; tenant portal</li><li>Online rent via Stripe</li><li>Maintenance requests</li><li>Tour booking + reminders</li><li>Multisite-ready</li></ul>[/wpb_col]
    [/wpb_row]', 'rw-section--mist' )
    . realwise_section( $cta );

    /* ---------- PRICING ---------- */
    $pricing = realwise_section( '
    <div class="text-center mb-5"><span class="rw-eyebrow">Pricing</span><h2 class="mt-2">Start free. Automate when you grow.</h2><p class="text-muted">No credit card to start &middot; cancel the MLS license anytime &mdash; the plugin keeps working.</p></div>
    [wpb_row gutter="4" valign="stretch"]
      [wpb_col lg="6"]
      <div class="rw-price">
        <h3 class="fw-bold">RealWise</h3><p class="text-muted">The complete platform &middot; Free forever</p>
        <div class="rw-price__amt">$0</div>
        <ul><li>All six modules, no feature paywall</li><li>Listings &amp; search + maps</li><li>Investor proformas &amp; deal score</li><li>CRM, agent portal &amp; tours</li><li>Property management + online rent</li></ul>
        ' . $buy_free . '
      </div>
      [/wpb_col]
      [wpb_col lg="6"]
      <div class="rw-price rw-price--featured">
        <h3 class="fw-bold">RealWise MLS</h3><p class="text-muted">Automated MLS / IDX import</p>
        <div class="rw-price__amt">$149 <span class="rw-price__per">/ year</span></div>
        <ul><li>Everything in RealWise (free)</li><li>RESO Web API + all vendor presets</li><li>Scheduled imports &amp; field mapping</li><li>One year of updates</li><li>Priority email support</li></ul>
        ' . $buy_mls . '
      </div>
      [/wpb_col]
    [/wpb_row]' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Compare</span><h2 class="mt-2">What is included</h2></div>
    <div class="table-responsive" style="max-width:720px;margin-inline:auto"><table class="table align-middle rw-compare-table">
      <thead><tr><th>Capability</th><th class="text-center">RealWise<br><span class="text-muted fw-normal">Free</span></th><th class="text-center">+ MLS<br><span class="text-muted fw-normal">$149/yr</span></th></tr></thead>
      <tbody>
        <tr><td>Listings, search &amp; maps</td><td class="text-center rw-y"></td><td class="text-center rw-y"></td></tr>
        <tr><td>Investor proformas &amp; deal score</td><td class="text-center rw-y"></td><td class="text-center rw-y"></td></tr>
        <tr><td>CRM, agent portal &amp; tours</td><td class="text-center rw-y"></td><td class="text-center rw-y"></td></tr>
        <tr><td>Property management + online rent</td><td class="text-center rw-y"></td><td class="text-center rw-y"></td></tr>
        <tr><td>Automated MLS / IDX import</td><td class="text-center rw-n"></td><td class="text-center rw-y"></td></tr>
        <tr><td>Automatic updates &amp; priority support</td><td class="text-center rw-n"></td><td class="text-center rw-y"></td></tr>
      </tbody>
    </table></div>', 'rw-section--mist' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Pricing FAQ</span><h2 class="mt-2">Before you click buy</h2></div>
    [wpb_accordion]
      [wpb_accordion_item title="Is the RealWise plugin really free?" open="true"]Yes &mdash; the full platform plugin is free and GPL-licensed, with no feature paywall. RealWise MLS is the only paid product, and it automates importing listings from your MLS.[/wpb_accordion_item]
      [wpb_accordion_item title="What does the MLS license include?"]A license key for one site, one year of automatic updates, and priority email support. Additional-site licenses are available &mdash; ask us.[/wpb_accordion_item]
      [wpb_accordion_item title="How are licenses delivered?"]Instantly. Checkout is handled by Easy Digital Downloads; your key and download link appear on the confirmation page and in your account.[/wpb_accordion_item]
      [wpb_accordion_item title="What if my MLS is not supported?"]RealWise MLS covers the RESO Web API plus every major vendor and a CSV/IDX importer. Ask us before buying and we will confirm yours.[/wpb_accordion_item]
      [wpb_accordion_item title="Can I cancel?"]Anytime. The plugin keeps importing after a license lapses; you simply stop receiving updates until you renew.[/wpb_accordion_item]
    [/wpb_accordion]' );

    /* ---------- DOCS ---------- */
    $docs = realwise_section( '
    <div class="text-center mb-5"><span class="rw-eyebrow">Documentation</span><h2 class="mt-2">Set up RealWise in minutes</h2><p class="text-muted">Three steps to a working real-estate site &mdash; then connect the extras when you are ready.</p></div>
    [wpb_row gutter="4"]
      [wpb_col md="4"][wpb_icon_box icon="bi-1-circle" title="Install &amp; activate" color="success" align="start"]Upload <code>realwise.zip</code> under Plugins &rarr; Add New and activate. The RealWise menu appears with a guided getting-started panel.[/wpb_icon_box][/wpb_col]
      [wpb_col md="4"][wpb_icon_box icon="bi-2-circle" title="Create your pages" color="success" align="start"]Add one page with <code>[rwls_search]</code> and one with <code>[rwls_listing]</code>, then select them under RealWise &rarr; Settings. That is a working IDX site.[/wpb_icon_box][/wpb_col]
      [wpb_col md="4"][wpb_icon_box icon="bi-3-circle" title="Connect the extras" color="success" align="start"]Add RealWise MLS for automated imports, Stripe for online rent, and your API keys for Walk Score, schools and maps.[/wpb_icon_box][/wpb_col]
    [/wpb_row]' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Guides</span><h2 class="mt-2">Set up each part</h2></div>
    [wpb_tabs style="pills" fill="true"]
      [wpb_tab title="Listings" icon="bi-house-door" active="true"]<h3 class="h5">Listings &amp; search</h3><ol><li>Create a <strong>Search</strong> page containing <code>[rwls_search]</code>.</li><li>Create a <strong>Listing</strong> page containing <code>[rwls_listing]</code>.</li><li>Under <strong>RealWise &rarr; Settings</strong>, select those two pages and add your Google Maps / Walk Score / GreatSchools keys.</li><li>Add listings by hand under <strong>RealWise &rarr; Listings</strong>, or automate them with RealWise MLS.</li></ol>[/wpb_tab]
      [wpb_tab title="MLS import" icon="bi-arrow-repeat"]<h3 class="h5">Automated MLS / IDX</h3><ol><li>Install <code>realwise-mls.zip</code> and enter your license key on the <strong>License</strong> screen.</li><li>Open <strong>RealWise MLS &rarr; Feeds &rarr; Add Feed</strong>, pick your adapter (RESO, FlexMLS/Spark, RETS, ATTOM, Crexi&hellip;) and paste credentials.</li><li>Map fields if your MLS uses non-standard names, set a schedule, then click <strong>Run Now</strong>.</li><li>No MLS yet? Use the <strong>Demo</strong> adapter to import 24 sample listings instantly.</li></ol>[/wpb_tab]
      [wpb_tab title="CRM" icon="bi-people"]<h3 class="h5">Leads &amp; CRM</h3><ol><li>Leads are captured automatically from contact, save-listing and tour forms.</li><li>Choose an assignment mode (round-robin, by listing, least-busy) under <strong>Leads &rarr; Settings</strong>.</li><li>Drop <code>[rwcr_lead_form]</code> anywhere for a standalone capture form.</li><li>Work the pipeline under <strong>Leads &rarr; Pipeline</strong>; enable the email drip to follow up automatically.</li></ol>[/wpb_tab]
      [wpb_tab title="Rent &amp; Stripe" icon="bi-building"]<h3 class="h5">Property management</h3><ol><li>Add properties, units and leases under <strong>Properties</strong>.</li><li>Enter your Stripe keys under <strong>Properties &rarr; Settings</strong> and set late-fee rules.</li><li>Give tenants <code>[pwpm_tenant_portal]</code> so they pay rent and file maintenance online.</li></ol>[/wpb_tab]
      [wpb_tab title="Tours" icon="bi-calendar-check"]<h3 class="h5">Tours &amp; scheduling</h3><ol><li>Set weekly availability under <strong>Tours &rarr; Availability</strong>.</li><li>Add <code>[rwtr_request_tour]</code> to listing pages.</li><li>Bookings send calendar invites and reminders, and create a hot lead in the CRM.</li></ol>[/wpb_tab]
    [/wpb_tabs]', 'rw-section--mist' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Reference</span><h2 class="mt-2">Shortcodes</h2></div>
    <div class="table-responsive"><table class="table align-middle">
      <thead><tr><th>Shortcode</th><th>What it shows</th></tr></thead>
      <tbody>
        <tr><td><code>[rwls_search]</code></td><td>Map-based property search</td></tr>
        <tr><td><code>[rwls_listing]</code></td><td>Single listing with scores &amp; mortgage</td></tr>
        <tr><td><code>[rwls_mortgage]</code></td><td>Mortgage calculator</td></tr>
        <tr><td><code>[rwls_saved_searches]</code></td><td>A visitor&rsquo;s saved searches &amp; alerts</td></tr>
        <tr><td><code>[rwdv_proforma]</code> &middot; <code>[rwdv_flip]</code> &middot; <code>[rwdv_renovation]</code></td><td>Investor proforma, fix-and-flip, renovation estimator</td></tr>
        <tr><td><code>[rwcr_lead_form]</code></td><td>Lead capture form</td></tr>
        <tr><td><code>[pwap_dashboard]</code></td><td>Front-end agent dashboard</td></tr>
        <tr><td><code>[pwpm_tenant_portal]</code></td><td>Tenant portal (rent + maintenance)</td></tr>
        <tr><td><code>[rwtr_request_tour]</code></td><td>Request-a-tour booking form</td></tr>
      </tbody>
    </table></div>' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Integrations</span><h2 class="mt-2">API keys &amp; services</h2><p class="text-muted">Add these under <strong>RealWise &rarr; Settings</strong>. Each is optional and only used when present.</p></div>
    <div class="table-responsive" style="max-width:760px;margin-inline:auto"><table class="table align-middle">
      <thead><tr><th>Service</th><th>Powers</th><th>Where to get it</th></tr></thead>
      <tbody>
        <tr><td>Google Maps</td><td>Map search &amp; geocoding</td><td>Google Cloud Console</td></tr>
        <tr><td>Walk Score</td><td>Walkability scores</td><td>walkscore.com/professional</td></tr>
        <tr><td>GreatSchools</td><td>School ratings</td><td>greatschools.org/api</td></tr>
        <tr><td>CrimeGrade</td><td>Crime overlays</td><td>crimegrade.org</td></tr>
        <tr><td>ATTOM</td><td>Property-data enrichment</td><td>api.developer.attomdata.com</td></tr>
        <tr><td>Stripe</td><td>Online rent payments</td><td>dashboard.stripe.com</td></tr>
      </tbody>
    </table></div>', 'rw-section--mist' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Help</span><h2 class="mt-2">FAQ &amp; troubleshooting</h2></div>
    [wpb_accordion]
      [wpb_accordion_item title="My MLS import returns nothing" open="true"]Re-check the adapter and credentials on the feed, confirm your IP is whitelisted with the MLS, and open <strong>RealWise MLS &rarr; Import Log</strong> for the exact error. Try the Demo adapter to confirm the pipeline works.[/wpb_accordion_item]
      [wpb_accordion_item title="The map or scores are blank"]Add the matching API keys under <strong>RealWise &rarr; Settings</strong>. Maps need a Google Maps key; Walk Score, crime and schools each need their own key.[/wpb_accordion_item]
      [wpb_accordion_item title="Rent payments are not going through"]Confirm your live Stripe keys are saved and the webhook endpoint is registered. Test-mode keys will not charge real cards.[/wpb_accordion_item]
      [wpb_accordion_item title="A shortcode shows as raw text"]Make sure the RealWise plugin is active. Shortcodes only render when the plugin that provides them is installed.[/wpb_accordion_item]
      [wpb_accordion_item title="Does it support multisite?"]Yes &mdash; installation, roles and the uninstall routine are all multisite-aware.[/wpb_accordion_item]
    [/wpb_accordion]' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">Resources</span><h2 class="mt-2">Keep going</h2></div>
    [wpb_row gutter="4"]
      [wpb_col md="4"][wpb_icon_box icon="bi-journal-code" title="Full documentation" color="success" align="start"]Deep-dive guides for every module and shortcode.<br><br>[wpb_button url="https://wprealwise.com/docs" style="outline-primary" size="sm"]Open the docs[/wpb_button][/wpb_icon_box][/wpb_col]
      [wpb_col md="4"][wpb_icon_box icon="bi-life-preserver" title="Priority support" color="success" align="start"]Email support from the team that built RealWise.<br><br>[wpb_button url="https://wprealwise.com/support" style="outline-primary" size="sm"]Get help[/wpb_button][/wpb_icon_box][/wpb_col]
      [wpb_col md="4"][wpb_icon_box icon="bi-bag-check" title="Automate your MLS" color="success" align="start"]Add RealWise MLS for scheduled listing imports.<br><br>[wpb_button url="/store/" style="success" size="sm"]Visit the store[/wpb_button][/wpb_icon_box][/wpb_col]
    [/wpb_row]', 'rw-section--mist' );

    /* ---------- ABOUT ---------- */
    $about = realwise_section( '
    <div class="text-center mb-5" style="max-width:760px;margin-inline:auto"><span class="rw-eyebrow">About</span><h2 class="mt-2">Real estate, done right on WordPress</h2><p class="lead mt-2">We replaced the tangle of half-compatible plugins most real-estate sites run with one coherent, well-built platform &mdash; that you actually own.</p></div>
    [wpb_row gutter="5" valign="center"]
      <div class="col-lg-6">
        <h3 class="h4 fw-bold">Why we built it</h3>
        <p>Every real-estate site we saw was a Frankenstein: an IDX plugin here, a CRM there, a SaaS for tours, a spreadsheet for the numbers. None of them shared data, each billed monthly, and every WordPress update was a gamble.</p>
        <p>We believed the whole lifecycle &mdash; discover, import, underwrite, capture, operate, tour and manage &mdash; belonged in one place, on software you control. So we built it, made the core free and GPL, and kept only the automated MLS importer commercial.</p>
        <p class="mb-0">Built and supported by <a href="https://wprealwise.com">WPRealWise.com</a>.</p>
      </div>
      <div class="col-lg-6">
        [wpb_row gutter="3"]
          [wpb_col size="6"][wpb_icon_box icon="bi-shield-check" title="Standards-first" color="success"]Passes WordPress.org Plugin Check &mdash; prepared SQL, escaped output, nonce-protected forms.[/wpb_icon_box][/wpb_col]
          [wpb_col size="6"][wpb_icon_box icon="bi-puzzle" title="Modular" color="success"]Six modules, one plugin &mdash; use what you need, ignore the rest.[/wpb_icon_box][/wpb_col]
          [wpb_col size="6"][wpb_icon_box icon="bi-hdd-network" title="You own it" color="success"]Self-hosted and GPL-licensed. Your data lives in your database.[/wpb_icon_box][/wpb_col]
          [wpb_col size="6"][wpb_icon_box icon="bi-life-preserver" title="Supported" color="success"]Priority email support for licensed RealWise MLS customers.[/wpb_icon_box][/wpb_col]
        [/wpb_row]
      </div>
    [/wpb_row]' )
    . realwise_section( '
    <div class="text-center"><span class="rw-eyebrow">By the numbers</span><h2 class="mt-2 mb-4">What is in the box</h2></div>
    [wpb_row gutter="4"]
      [wpb_col md="3"][wpb_icon_box icon="bi-boxes" title="6 modules" color="success" align="center"]One free plugin[/wpb_icon_box][/wpb_col]
      [wpb_col md="3"][wpb_icon_box icon="bi-arrow-repeat" title="14 MLS adapters" color="success" align="center"]RESO + every major vendor[/wpb_icon_box][/wpb_col]
      [wpb_col md="3"][wpb_icon_box icon="bi-patch-check" title="100% clean" color="success" align="center"]Plugin-Check passing[/wpb_icon_box][/wpb_col]
      [wpb_col md="3"][wpb_icon_box icon="bi-cash" title="$0 to start" color="success" align="center"]No card required[/wpb_icon_box][/wpb_col]
    [/wpb_row]', 'rw-section--mist' )
    . realwise_section( $cta );

    /* ---------- CONTACT ---------- */
    $contact = realwise_section( '
    <div class="text-center mb-5"><span class="rw-eyebrow">Contact</span><h2 class="mt-2">Talk to us</h2><p class="text-muted">Sales, support or partnership questions — we are happy to help.</p></div>
    [wpb_row gutter="5"]
      [wpb_col lg="5"]
        [wpb_contact_info phone="+1 (555) 010-0100" email="hello@wprealwise.com" address="WPRealWise, Online" hours="Mon–Fri, 9–5"]
        <div class="mt-4">[wpb_card title="Need product help?" shadow="sm"]Licensed RealWise MLS customers get priority email support. Include your license key and site URL.<br><br>[wpb_button url="https://wprealwise.com/support" style="primary" icon="bi-life-preserver"]Open a support ticket[/wpb_button][/wpb_card]</div>
      [/wpb_col]
      [wpb_col lg="7"]
        <h3 class="h4 fw-bold mb-3">Send us a message</h3>
        [realwise_contact_form]
      [/wpb_col]
    [/wpb_row]' );

    /* ---------- STORE ---------- */
    $store = realwise_section( '
    <div class="text-center mb-5" style="max-width:740px;margin-inline:auto"><span class="rw-eyebrow">Store</span><h2 class="mt-2">Get RealWise</h2><p class="text-muted mt-2">Download the free platform, or buy the MLS add-on and get your license key the moment you check out.</p></div>
    [wpb_row gutter="4" valign="stretch"]
      [wpb_col lg="6"]
      <div class="rw-price h-100">
        <span class="badge bg-light text-dark mb-2">Free &middot; GPL</span>
        <h3 class="fw-bold">RealWise</h3><p class="text-muted">The complete platform</p>
        <div class="rw-price__amt">$0</div>
        <ul><li>All six modules &mdash; no paywall</li><li>Self-hosted, your data</li><li>Listings, CRM, investor, rentals, tours</li><li>Community support</li></ul>
        ' . $buy_free . '
      </div>
      [/wpb_col]
      [wpb_col lg="6"]
      <div class="rw-price rw-price--featured h-100">
        <span class="badge bg-success mb-2">Best value</span>
        <h3 class="fw-bold">RealWise MLS</h3><p class="text-muted">Automated MLS / IDX import</p>
        <div class="rw-price__amt">$149 <span class="rw-price__per">/ year</span></div>
        <ul><li>Everything in RealWise (free)</li><li>RESO Web API + every major vendor</li><li>Scheduled imports &amp; field mapping</li><li>1 year of updates + priority support</li></ul>
        ' . $buy_mls . '
      </div>
      [/wpb_col]
    [/wpb_row]' )
    . realwise_section( '
    <div class="text-center mb-4"><span class="rw-eyebrow">What you get</span><h2 class="mt-2">Instant delivery, real support</h2></div>
    [wpb_row gutter="4"]
      [wpb_col md="3"][wpb_icon_box icon="bi-lightning-charge" title="Instant download" color="success" align="center"]Your key &amp; download link appear the moment you check out.[/wpb_icon_box][/wpb_col]
      [wpb_col md="3"][wpb_icon_box icon="bi-arrow-repeat" title="Automatic updates" color="success" align="center"]New versions install in one click for a full year.[/wpb_icon_box][/wpb_col]
      [wpb_col md="3"][wpb_icon_box icon="bi-life-preserver" title="Priority support" color="success" align="center"]Email support from the people who built it.[/wpb_icon_box][/wpb_col]
      [wpb_col md="3"][wpb_icon_box icon="bi-unlock" title="No lock-in" color="success" align="center"]The plugin keeps working if you do not renew.[/wpb_icon_box][/wpb_col]
    [/wpb_row]
    <p class="text-center text-muted mt-4"><i class="bi bi-shield-check text-success me-1"></i>Secure checkout via Easy Digital Downloads &middot; no card details stored on our server</p>', 'rw-section--mist' );

    $blog = '<p class="lead text-muted">' . esc_html__( 'Guides, release notes and ideas for running real estate on WordPress.', 'realwise' ) . '</p>';

    return [
        'home'     => [ 'title' => __( 'Home', 'realwise' ),     'content' => $home,          'template' => $tpl ],
        'features' => [ 'title' => __( 'Features', 'realwise' ), 'content' => $features_page, 'template' => $tpl ],
        'pricing'  => [ 'title' => __( 'Pricing', 'realwise' ),  'content' => $pricing,       'template' => $tpl ],
        'store'    => [ 'title' => __( 'Store', 'realwise' ),    'content' => $store,         'template' => $tpl ],
        'docs'     => [ 'title' => __( 'Docs', 'realwise' ),     'content' => $docs,          'template' => $tpl ],
        'about'    => [ 'title' => __( 'About', 'realwise' ),    'content' => $about,         'template' => $tpl ],
        'contact'  => [ 'title' => __( 'Contact', 'realwise' ),  'content' => $contact,       'template' => $tpl ],
        'blog'     => [ 'title' => __( 'Blog', 'realwise' ),     'content' => $blog ],
    ];
}
