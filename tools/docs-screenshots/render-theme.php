<?php
/**
 * Renders one theme's front page to static HTML using the theme's own
 * templates, so documentation screenshots show real output.
 *
 * Usage: php render-theme.php <out-dir> <wpwisebones|realwise|aec-forge>
 *
 * @package WPWiseBones\Tools
 */

require __DIR__ . '/wp-stub.php';
define( 'OBJECT', 'OBJECT' );

$repo    = dirname( __DIR__, 2 );
$out_dir = rtrim( $argv[1], '/' );
$theme   = $argv[2];

require __DIR__ . '/sample-data.php';

global $wp_stub;
$ph              = wpb_placeholders( $out_dir . '/img' );
$wp_stub['posts'] = wpb_sample_posts( $ph );
$wp_stub['post']  = $wp_stub['posts'][0];

$wp_stub['options'] = array(
	'wpwisebones_options' => array(
		'back_to_top' => true,
		'breadcrumbs' => false,
	),
);

switch ( $theme ) {
	case 'realwise':
		$parent = 'wpwisebones';
		$child  = 'realwise';
		$tpl    = "$repo/realwise/front-page.php";
		$wp_stub['blogname']        = 'RealWise';
		$wp_stub['blogdescription'] = 'Real estate tools for the invested realtor';
		$wp_stub['menu']            = array(
			array( 'Home', '#' ), array( 'Features', '#' ), array( 'Pricing', '#' ),
			array( 'Docs', '#' ), array( 'Store', '#' ), array( 'Blog', '#' ),
			array( 'About', '#' ), array( 'Contact', '#' ),
		);
		break;

	case 'aec-forge':
		$parent = 'wpwisebones';
		$child  = 'aec-forge';
		$tpl    = "$repo/aec-forge/front-page.php";
		$wp_stub['blogname']        = 'AEC Forge';
		$wp_stub['blogdescription'] = 'The marketplace for AEC, BIM and Excel specialists';
		$wp_stub['menu']            = array(
			array( 'Home', '#' ), array( 'Marketplace', '#' ), array( 'Forge Tools', '#' ),
			array( 'How it works', '#' ), array( 'Pricing', '#' ), array( 'Become a vendor', '#' ),
		);
		break;

	default:
		$parent = 'wpwisebones';
		$child  = null;
		$tpl    = "$repo/wpwisebones/index.php";
		$wp_stub['blogname']        = 'WPWiseBones';
		$wp_stub['blogdescription'] = 'A Bootstrap 5 starter theme for WordPress';
		$wp_stub['menu']            = array(
			array( 'Home', '#' ), array( 'Features', '#' ), array( 'Shortcodes', '#' ),
			array( 'Blog', '#' ), array( 'Contact', '#' ),
		);
		$wp_stub['theme_mods'] = array(
			'wpwisebones_hero_heading'    => 'Bootstrap 5, the WordPress way',
			'wpwisebones_hero_subheading' => 'The full template hierarchy, a Customizer panel set and seventeen Bootstrap shortcodes — with nothing that fails theme review.',
			'wpwisebones_hero_btn_text'   => 'Get started',
			'wpwisebones_hero_btn_url'    => '#',
			'wpwisebones_footer_copyright' => '&copy; 2025 WPWiseBones — GPL-2.0-or-later',
			'wpwisebones_social_github'   => 'https://github.com/ibuilder/WPWiseBones',
		);
		break;
}

$wp_stub['is_front_page'] = true;
$wp_stub['is_home']       = false;

wpb_boot_theme( $repo, $parent, $child );

/* The shortcodes plugin ships the [wpb_*] components used by child pages. */
$wp_stub['plugin_uri'] = "file://$repo/wisebones-shortcodes/";
require_once "$repo/wisebones-shortcodes/wisebones-shortcodes.php";

ob_start();
include $tpl;
$html = (string) ob_get_clean();

$file = "$out_dir/theme-$theme.html";
file_put_contents( $file, $html );
fwrite( STDOUT, "Rendered $theme front page → $file\n" );
