<?php
/**
 * Plugin Name:       WiseBones Shortcodes
 * Plugin URI:        https://wprealwise.com/wpwisebones
 * Description:       17 Bootstrap 5 shortcodes â€” alerts, buttons, cards, accordions, tabs, grid columns, CTA banners, icon boxes, progress bars, testimonials, countdown timers, post grids, modals, badges, dividers, maps, and contact info. Works with any Bootstrap 5 theme; Bootstrap is auto-loaded when not already provided by the active theme.
 * Version:           1.0.4
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            WPWiseBones
 * Author URI:        https://wprealwise.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wisebones-shortcodes
 *
 * Copyright (C) 2025 WPWiseBones (https://wprealwise.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

defined( 'ABSPATH' ) || exit;

define( 'WPBS_VERSION', '1.0.4' );
define( 'WPBS_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPBS_URI', plugin_dir_url( __FILE__ ) );

/* â”€â”€ Load all shortcodes â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

$wpbs_shortcodes = array(
	'sc-alert.php',
	'sc-button.php',
	'sc-card.php',
	'sc-accordion.php',
	'sc-tabs.php',
	'sc-columns.php',
	'sc-cta.php',
	'sc-icon-box.php',
	'sc-progress.php',
	'sc-testimonial.php',
	'sc-countdown.php',
	'sc-posts.php',
	'sc-modal.php',
	'sc-badge.php',
	'sc-divider.php',
	'sc-map.php',
	'sc-contact-info.php',
);

foreach ( $wpbs_shortcodes as $wpbs_file ) {
	$wpbs_path = WPBS_DIR . 'shortcodes/' . $wpbs_file;
	if ( file_exists( $wpbs_path ) ) {
		require_once $wpbs_path;
	}
}

/* â”€â”€ Auto-load Bootstrap + Icons if not already provided â”€â”€â”€â”€â”€ */

add_action( 'wp_enqueue_scripts', 'wpbs_enqueue_assets', 20 );

function wpbs_enqueue_assets() {
	if ( ! wp_style_is( 'bootstrap', 'registered' ) ) {
		wp_enqueue_style(
			'bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
			array(),
			'5.3.3'
		);
	}

	if ( ! wp_script_is( 'bootstrap', 'registered' ) ) {
		wp_enqueue_script(
			'bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
			array(),
			'5.3.3',
			true
		);
	}

	if ( ! wp_style_is( 'bootstrap-icons', 'registered' ) ) {
		wp_enqueue_style(
			'bootstrap-icons',
			'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
			array(),
			'1.11.3'
		);
	}

	wp_enqueue_script(
		'wpbs-countdown',
		WPBS_URI . 'assets/js/wpbs-countdown.js',
		array(),
		WPBS_VERSION,
		true
	);
}

/* â”€â”€ Admin: shortcode reference page â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'admin_menu', 'wpbs_admin_menu' );

function wpbs_admin_menu() {
	add_plugins_page(
		__( 'WiseBones Shortcodes', 'wisebones-shortcodes' ),
		__( 'WiseBones Shortcodes', 'wisebones-shortcodes' ),
		'edit_posts',
		'wisebones-shortcodes',
		'wpbs_reference_page'
	);
}

function wpbs_reference_page() {
	$wpbs_ref_shortcodes = array(
		'[wpb_alert type="success" dismissible="true"]Message[/wpb_alert]' => __( 'Bootstrap dismissible alert', 'wisebones-shortcodes' ),
		'[wpb_button url="/page" style="primary" size="lg" icon="bi-envelope"]Label[/wpb_button]' => __( 'Button with icon support', 'wisebones-shortcodes' ),
		'[wpb_card title="Title" image="URL" btn_text="More" btn_url="#"]Body[/wpb_card]' => __( 'Bootstrap card component', 'wisebones-shortcodes' ),
		'[wpb_accordion][wpb_accordion_item title="Q"]A[/wpb_accordion_item][/wpb_accordion]' => __( 'Accordion / FAQ', 'wisebones-shortcodes' ),
		'[wpb_tabs][wpb_tab title="Tab 1" active="true"]Content[/wpb_tab][/wpb_tabs]' => __( 'Tabbed content', 'wisebones-shortcodes' ),
		'[wpb_row gutter="4"][wpb_col size="6"]Left[/wpb_col][wpb_col size="6"]Right[/wpb_col][/wpb_row]' => __( 'Bootstrap grid columns', 'wisebones-shortcodes' ),
		'[wpb_cta heading="Ready?" btn_text="Start" btn_url="/contact"]Subtext[/wpb_cta]' => __( 'Call-to-action banner', 'wisebones-shortcodes' ),
		'[wpb_icon_box icon="bi-rocket" title="Fast"]Description[/wpb_icon_box]' => __( 'Icon feature box', 'wisebones-shortcodes' ),
		'[wpb_progress label="HTML" value="90" color="primary"]' => __( 'Animated progress bar', 'wisebones-shortcodes' ),
		'[wpb_testimonial author="Jane Doe" role="CEO" stars="5"]Quote[/wpb_testimonial]' => __( 'Star-rated testimonial', 'wisebones-shortcodes' ),
		'[wpb_countdown date="2025-12-31 23:59:59" label="Launching in"]' => __( 'Live countdown timer', 'wisebones-shortcodes' ),
		'[wpb_posts count="3" columns="3" category="news" show_excerpt="true"]' => __( 'Post grid from query', 'wisebones-shortcodes' ),
		'[wpb_modal title="Title" btn_text="Open"]Modal body[/wpb_modal]' => __( 'Bootstrap modal popup', 'wisebones-shortcodes' ),
		'[wpb_badge color="danger" pill="true"]Hot[/wpb_badge]' => __( 'Inline badge / label', 'wisebones-shortcodes' ),
		'[wpb_divider text="OR" style="dashed"]' => __( 'Styled divider / HR', 'wisebones-shortcodes' ),
		'[wpb_map src="https://maps.google.com/maps?q=New+York&output=embed" height="400"]' => __( 'Responsive map embed', 'wisebones-shortcodes' ),
		'[wpb_contact_info phone="+1 555 0100" email="hello@example.com" address="123 Main St"]' => __( 'Contact information list', 'wisebones-shortcodes' ),
	);
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'WiseBones Shortcodes Reference', 'wisebones-shortcodes' ); ?></h1>
		<p><?php esc_html_e( 'Use these shortcodes anywhere in your posts, pages, or widgets.', 'wisebones-shortcodes' ); ?></p>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Shortcode', 'wisebones-shortcodes' ); ?></th>
					<th><?php esc_html_e( 'Description', 'wisebones-shortcodes' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ( $wpbs_ref_shortcodes as $wpbs_sc => $wpbs_desc ) : ?>
				<tr>
					<td><code><?php echo esc_html( $wpbs_sc ); ?></code></td>
					<td><?php echo esc_html( $wpbs_desc ); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p style="margin-top:2rem;color:#666">
			<?php esc_html_e( 'Brought to you by', 'wisebones-shortcodes' ); ?>
			<a href="https://wprealwise.com" target="_blank" rel="noopener noreferrer">wprealwise.com</a>
		</p>
	</div>
	<?php
}

/* â”€â”€ Theme cross-reference helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpbs_theme_active() {
	return 'wpwisebones' === wp_get_theme()->get_template();
}

/* â”€â”€ Admin notice (plugins page only) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'admin_notices', 'wpbs_theme_notice' );

function wpbs_theme_notice() {
	if ( wpbs_theme_active() ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'plugins' !== $screen->id ) {
		return;
	}

	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<strong><?php esc_html_e( 'WiseBones Shortcodes', 'wisebones-shortcodes' ); ?></strong> &mdash;
			<?php
			printf(
				wp_kses(
					/* translators: %s: WPWiseBones theme hyperlink */
					__( 'Pairs perfectly with the free %s theme for a full Bootstrap 5 WordPress experience.', 'wisebones-shortcodes' ),
					array(
						'a'      => array(
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
						),
						'strong' => array(),
					)
				),
				'<a href="' . esc_url( admin_url( 'theme-install.php?search=wpwisebones' ) ) . '"><strong>WPWiseBones</strong></a>'
			);
			?>
		</p>
	</div>
	<?php
}
