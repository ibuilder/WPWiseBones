<?php
/**
 * Featured listings or projects from the Industry Kit.
 *
 * With nothing published yet the section is hidden from visitors; the owner
 * (and the Customizer preview) sees the config's samples, marked as samples,
 * so the layout can be judged before real content exists.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_type    = isset( $wpwisebones_section['type'] ) && 'project' === $wpwisebones_section['type'] ? 'project' : 'listing';
$wpwisebones_count   = isset( $wpwisebones_section['count'] ) ? absint( $wpwisebones_section['count'] ) : 3;
$wpwisebones_posts   = wpwisebones_industry_items( $wpwisebones_type, $wpwisebones_count ? $wpwisebones_count : 3 );
$wpwisebones_cards   = array();

foreach ( $wpwisebones_posts as $wpwisebones_post ) {
	$wpwisebones_cards[] = array(
		'title'  => get_the_title( $wpwisebones_post ),
		'url'    => get_permalink( $wpwisebones_post ),
		'image'  => get_the_post_thumbnail( $wpwisebones_post, 'wpwisebones-card', array( 'class' => 'wpb-ind-media__img' ) ),
		'id'     => $wpwisebones_post->ID,
		'sample' => false,
	);
}

if ( ! $wpwisebones_cards && ! empty( $wpwisebones_section['samples'] ) && wpwisebones_industry_can_preview() ) {
	foreach ( (array) $wpwisebones_section['samples'] as $wpwisebones_sample ) {
		$wpwisebones_cards[] = array_merge(
			array(
				'url'    => '',
				'image'  => '',
				'id'     => 0,
				'sample' => true,
			),
			(array) $wpwisebones_sample
		);
	}
}

if ( ! $wpwisebones_cards ) {
	return;
}

$wpwisebones_archive = post_type_exists( wpwisebones_industry_post_type( $wpwisebones_type ) ) ? get_post_type_archive_link( wpwisebones_industry_post_type( $wpwisebones_type ) ) : '';
?>
<section class="wpb-ind-section wpb-ind-featured wpb-ind-featured--<?php echo esc_attr( $wpwisebones_type ); ?>" id="featured">
	<div class="container">
		<?php wpwisebones_industry_heading( $wpwisebones_section ); ?>
		<div class="row g-4">
			<?php foreach ( $wpwisebones_cards as $wpwisebones_card ) : ?>
				<div class="col-md-6 col-lg-4">
					<?php get_template_part( 'template-parts/industry/card', $wpwisebones_type, array( 'card' => $wpwisebones_card ) ); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( $wpwisebones_archive ) : ?>
			<p class="text-center mt-5 mb-0">
				<a class="btn btn-outline-primary" href="<?php echo esc_url( $wpwisebones_archive ); ?>">
					<?php
					/* translators: %s: plural content label, e.g. "Listings". */
					echo esc_html( sprintf( __( 'View all %s', 'wpwisebones' ), strtolower( wpwisebones_industry_type_label( $wpwisebones_type ) ) ) );
					?>
					&rarr;
				</a>
			</p>
		<?php endif; ?>
	</div>
</section>
