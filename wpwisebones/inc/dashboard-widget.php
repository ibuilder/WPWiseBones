<?php
/**
 * WPWiseBones — Dashboard Widget
 *
 * Displays a "Getting Started" panel on the WordPress dashboard
 * with quick links, shortcode reference, and theme info.
 *
 * @package WPWiseBones
 * @link    https://wprealwise.com
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_dashboard_setup', 'wpb_register_dashboard_widget' );

function wpb_register_dashboard_widget() {
    wp_add_dashboard_widget(
        'wpb_getting_started',
        sprintf(
            /* translators: %s: theme version */
            __( 'WPWiseBones — Getting Started (v%s)', 'wpwisebones' ),
            WPB_VERSION
        ),
        'wpb_dashboard_widget_render',
        null,
        null,
        'normal',
        'high'
    );
}

function wpb_dashboard_widget_render() {
    $customize_url  = admin_url( 'customize.php' );
    $options_url    = admin_url( 'themes.php?page=wpb-theme-options' );
    $menus_url      = admin_url( 'nav-menus.php' );
    $widgets_url    = admin_url( 'widgets.php' );
    $docs_url       = WPB_DOCS_URL;
    $support_url    = WPB_SUPPORT_URL;
    ?>
    <style>
        #wpb_getting_started .inside { padding: 0; }
        .wpb-dw-header {
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            color: #fff;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .wpb-dw-header .wpb-dw-logo { font-size: 2rem; line-height: 1; }
        .wpb-dw-header h3 { margin: 0; font-size: 1.05rem; color: #fff; }
        .wpb-dw-header small { opacity: .8; font-size: .8rem; }
        .wpb-dw-header a { color: #fff; text-decoration: underline; }
        .wpb-dw-body { padding: 16px 20px; }
        .wpb-dw-steps { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
        .wpb-dw-step {
            display: flex; align-items: flex-start; gap: 10px;
            background: #f6f7f7; border-radius: 6px; padding: 12px;
            text-decoration: none; color: #1d2327; border: 1px solid #e0e0e0;
            transition: border-color .15s, box-shadow .15s;
        }
        .wpb-dw-step:hover { border-color: #0d6efd; box-shadow: 0 0 0 2px rgba(13,110,253,.15); color: #1d2327; text-decoration: none; }
        .wpb-dw-step .step-icon { font-size: 1.4rem; line-height: 1; flex-shrink: 0; }
        .wpb-dw-step .step-label { font-weight: 600; font-size: .85rem; display: block; }
        .wpb-dw-step .step-desc  { font-size: .78rem; color: #666; }
        .wpb-dw-sc { background: #f0f6ff; border: 1px solid #c8deff; border-radius: 6px; padding: 12px 16px; margin-bottom: 14px; }
        .wpb-dw-sc h4 { margin: 0 0 8px; font-size: .85rem; text-transform: uppercase; letter-spacing: .04em; color: #0d6efd; }
        .wpb-dw-sc-grid { display: flex; flex-wrap: wrap; gap: 5px; }
        .wpb-dw-sc-grid code { font-size: .75rem; background: #fff; border: 1px solid #c8deff; border-radius: 4px; padding: 2px 6px; cursor: pointer; }
        .wpb-dw-sc-grid code:hover { background: #0d6efd; color: #fff; border-color: #0d6efd; }
        .wpb-dw-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; padding-top: 12px; border-top: 1px solid #eee; font-size: .8rem; color: #777; }
        .wpb-dw-footer a { color: #0d6efd; text-decoration: none; }
        .wpb-dw-footer a:hover { text-decoration: underline; }
    </style>

    <div class="wpb-dw-header">
        <div class="wpb-dw-logo">&#9889;</div>
        <div>
            <h3><?php esc_html_e( 'WPWiseBones', 'wpwisebones' ); ?></h3>
            <small>
                <?php printf(
                    /* translators: %s: wprealwise.com link */
                    esc_html__( 'Bootstrap 5 WordPress starter — by %s', 'wpwisebones' ),
                    '<a href="' . esc_url( $docs_url ) . '" target="_blank" rel="noopener">wprealwise.com</a>'
                ); ?>
            </small>
        </div>
    </div>

    <div class="wpb-dw-body">

        <!-- Quick Setup Steps -->
        <div class="wpb-dw-steps">
            <a href="<?php echo esc_url( $customize_url ); ?>" class="wpb-dw-step">
                <span class="step-icon">&#127912;</span>
                <div>
                    <span class="step-label"><?php esc_html_e( 'Customizer', 'wpwisebones' ); ?></span>
                    <span class="step-desc"><?php esc_html_e( 'Colours, fonts, layout, hero', 'wpwisebones' ); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url( $options_url ); ?>" class="wpb-dw-step">
                <span class="step-icon">&#9881;</span>
                <div>
                    <span class="step-label"><?php esc_html_e( 'Theme Options', 'wpwisebones' ); ?></span>
                    <span class="step-desc"><?php esc_html_e( 'SEO, performance, custom CSS/JS', 'wpwisebones' ); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url( $menus_url ); ?>" class="wpb-dw-step">
                <span class="step-icon">&#9776;</span>
                <div>
                    <span class="step-label"><?php esc_html_e( 'Menus', 'wpwisebones' ); ?></span>
                    <span class="step-desc"><?php esc_html_e( 'Primary, Footer, Top Bar', 'wpwisebones' ); ?></span>
                </div>
            </a>
            <a href="<?php echo esc_url( $widgets_url ); ?>" class="wpb-dw-step">
                <span class="step-icon">&#128196;</span>
                <div>
                    <span class="step-label"><?php esc_html_e( 'Widgets', 'wpwisebones' ); ?></span>
                    <span class="step-desc"><?php esc_html_e( 'Sidebar, footer columns, header', 'wpwisebones' ); ?></span>
                </div>
            </a>
        </div>

        <!-- Companion Plugin Status -->
        <?php if ( ! wpb_companion_active() ) : ?>
        <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:6px;padding:11px 14px;margin-bottom:14px;display:flex;align-items:center;gap:12px;flex-wrap:wrap">
            <div style="flex-grow:1;font-size:.82rem">
                <strong>&#9888; <?php esc_html_e( "WPWiseBones Shortcodes not installed", "wpwisebones" ); ?></strong><br>
                <?php esc_html_e( "Install the free companion plugin to unlock 17 Bootstrap shortcodes.", "wpwisebones" ); ?>
            </div>
            <a href="<?php echo esc_url( wp_nonce_url( admin_url( "update.php?action=install-plugin&plugin=wisebones-shortcodes" ), "install-plugin_wisebones-shortcodes" ) ); ?>" class="button button-primary button-small">
                &#8659; <?php esc_html_e( "Install Now", "wpwisebones" ); ?>
            </a>
        </div>
        <?php else : ?>
        <div style="background:#d1e7dd;border:1px solid #a3cfbb;border-radius:6px;padding:8px 14px;margin-bottom:14px;font-size:.82rem;display:flex;align-items:center;gap:8px">
            <span style="color:#0f5132;font-size:1.1rem">&#10003;</span>
            <strong style="color:#0f5132"><?php esc_html_e( "WPWiseBones Shortcodes: Active", "wpwisebones" ); ?></strong>
            &nbsp;&mdash;&nbsp;
            <a href="<?php echo esc_url( admin_url( "plugins.php?page=wisebones-shortcodes" ) ); ?>" style="font-size:.82rem"><?php esc_html_e( "View Reference", "wpwisebones" ); ?></a>
        </div>
        <?php endif; ?>

        <!-- Shortcode Quick Reference -->
        <div class="wpb-dw-sc">
            <h4><?php esc_html_e( 'Shortcodes — click to copy (requires companion plugin)', 'wpwisebones' ); ?></h4>
            <div class="wpb-dw-sc-grid">
                <?php
                $shortcodes = [
                    '[wpb_alert type="success"]Text[/wpb_alert]',
                    '[wpb_button url="#" style="primary"]Label[/wpb_button]',
                    '[wpb_card title="Title" image="URL"]Body[/wpb_card]',
                    '[wpb_accordion][wpb_accordion_item title="Q"]A[/wpb_accordion_item][/wpb_accordion]',
                    '[wpb_tabs][wpb_tab title="Tab" active="true"]Content[/wpb_tab][/wpb_tabs]',
                    '[wpb_row][wpb_col size="6"]Left[/wpb_col][wpb_col size="6"]Right[/wpb_col][/wpb_row]',
                    '[wpb_cta heading="Title" btn_text="Go" btn_url="#"]',
                    '[wpb_icon_box icon="bi-star" title="Title"]Desc[/wpb_icon_box]',
                    '[wpb_progress label="Skill" value="85" color="primary"]',
                    '[wpb_testimonial author="Name" stars="5"]Quote[/wpb_testimonial]',
                    '[wpb_countdown date="2025-12-31"]',
                    '[wpb_posts count="3" columns="3"]',
                    '[wpb_modal title="Title" btn_text="Open"]Body[/wpb_modal]',
                    '[wpb_badge color="danger"]Hot[/wpb_badge]',
                    '[wpb_divider text="OR"]',
                    '[wpb_map src="EMBED_URL" height="400"]',
                    '[wpb_contact_info phone="+1…" email="…"]',
                ];
                foreach ( $shortcodes as $sc ) :
                ?>
                    <code
                        title="<?php echo esc_attr( $sc ); ?>"
                        onclick="navigator.clipboard.writeText('<?php echo esc_js( $sc ); ?>').then(()=>{ this.style.background='#198754'; this.style.color='#fff'; setTimeout(()=>{ this.style.background=''; this.style.color=''; },1000); })"
                    ><?php echo esc_html( explode( ' ', ltrim( $sc, '[' ) )[0] ); ?></code>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Widget Areas Info -->
        <div style="background:#f6f7f7;border:1px solid #e0e0e0;border-radius:6px;padding:10px 14px;margin-bottom:14px;font-size:.8rem">
            <strong><?php esc_html_e( 'Widget Areas:', 'wpwisebones' ); ?></strong>
            <?php
            $areas = [
                __( 'Primary Sidebar', 'wpwisebones' ),
                __( 'Footer ×4 columns', 'wpwisebones' ),
                __( 'Header', 'wpwisebones' ),
                __( 'Before Content', 'wpwisebones' ),
                __( 'After Content', 'wpwisebones' ),
                __( 'Shop Sidebar', 'wpwisebones' ),
            ];
            echo esc_html( implode( ' &nbsp;·&nbsp; ', $areas ) );
            ?>
        </div>

        <!-- System Info -->
        <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:6px;padding:10px 14px;margin-bottom:14px;font-size:.78rem">
            <?php
            $local = defined( 'WPB_LOCAL_ASSETS' ) && WPB_LOCAL_ASSETS;
            $php_v = phpversion();
            $wp_v  = get_bloginfo( 'version' );
            printf(
                /* translators: 1: PHP version, 2: WP version, 3: asset mode */
                esc_html__( 'PHP %1$s &nbsp;·&nbsp; WordPress %2$s &nbsp;·&nbsp; Assets: %3$s', 'wpwisebones' ),
                esc_html( $php_v ),
                esc_html( $wp_v ),
                $local
                    ? '<span style="color:#198754;font-weight:600">' . esc_html__( 'Local vendor', 'wpwisebones' ) . '</span>'
                    : '<span style="color:#0d6efd">' . esc_html__( 'CDN (jsDelivr)', 'wpwisebones' ) . '</span>'
            );
            ?>
            <?php if ( ! $local ) : ?>
                &nbsp;—&nbsp;
                <a href="https://wprealwise.com/docs/local-assets" target="_blank" rel="noopener" style="font-size:.78rem">
                    <?php esc_html_e( 'Switch to local for CSP compliance', 'wpwisebones' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Footer links -->
        <div class="wpb-dw-footer">
            <span>
                WPWiseBones v<?php echo esc_html( WPB_VERSION ); ?>
                &nbsp;&mdash;&nbsp;
                <a href="<?php echo esc_url( WPB_AUTHOR_URL ); ?>" target="_blank" rel="noopener">wprealwise.com</a>
            </span>
            <span>
                <a href="<?php echo esc_url( $docs_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Docs', 'wpwisebones' ); ?></a>
                &nbsp;&middot;&nbsp;
                <a href="<?php echo esc_url( $support_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Support', 'wpwisebones' ); ?></a>
                &nbsp;&middot;&nbsp;
                <a href="<?php echo esc_url( $options_url ); ?>"><?php esc_html_e( 'Theme Options', 'wpwisebones' ); ?></a>
            </span>
        </div>
    </div>
    <?php
}
