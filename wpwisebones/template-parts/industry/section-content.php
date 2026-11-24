<?php
/**
 * The static front page's own block content, so the owner can add anything
 * the sections do not cover by editing the "Home" page.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_front = (int) get_option( 'page_on_front' );
if ( ! $wpwisebones_front || 'page' !== get_option( 'show_on_front' ) ) {
	return;
}
$wpwisebones_page = get_post( $wpwisebones_front );
if ( ! $wpwisebones_page || '' === trim( (string) $wpwisebones_page->post_content ) ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-content" id="more">
	<div class="container">
		<div class="entry-content">
			<?php echo apply_filters( 'the_content', $wpwisebones_page->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped, WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- fires core's the_content filter, same as the_content(). ?>
		</div>
	</div>
</section>
