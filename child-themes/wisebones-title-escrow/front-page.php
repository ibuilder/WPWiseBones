<?php
/**
 * Front page: the sections listed in industry-config.php, rendered by the
 * parent. Override any one section by copying
 * wpwisebones/template-parts/industry/section-{name}.php into this theme.
 *
 * @package WiseBones_Title_Escrow
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( function_exists( 'wpwisebones_industry_front_page' ) ) {
	wpwisebones_industry_front_page();
} else {
	get_template_part( 'template-parts/content/content', 'none' );
}

get_footer();
