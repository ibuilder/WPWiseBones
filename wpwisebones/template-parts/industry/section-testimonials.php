<?php
/**
 * Client testimonials from the Industry Kit.
 *
 * Visitors only ever see real, published testimonials. The config's samples
 * are shown to the owner while the section is empty, labelled as samples, and
 * are never shown publicly — a made-up review on a live site would mislead.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_quotes  = array();

foreach ( wpwisebones_industry_items( 'testimonial', 3 ) as $wpwisebones_post ) {
	$wpwisebones_quotes[] = array(
		'quote'  => wp_strip_all_tags( get_post_field( 'post_content', $wpwisebones_post ) ),
		'name'   => wpwisebones_industry_meta( $wpwisebones_post->ID, 'author_name' ) ? wpwisebones_industry_meta( $wpwisebones_post->ID, 'author_name' ) : get_the_title( $wpwisebones_post ),
		'role'   => wpwisebones_industry_meta( $wpwisebones_post->ID, 'author_role' ),
		'rating' => (int) wpwisebones_industry_meta( $wpwisebones_post->ID, 'rating' ),
		'sample' => false,
	);
}

if ( ! $wpwisebones_quotes && ! empty( $wpwisebones_section['samples'] ) && wpwisebones_industry_can_preview() ) {
	foreach ( (array) $wpwisebones_section['samples'] as $wpwisebones_sample ) {
		$wpwisebones_quotes[] = array(
			'quote'  => $wpwisebones_sample[0],
			'name'   => $wpwisebones_sample[1],
			'role'   => isset( $wpwisebones_sample[2] ) ? $wpwisebones_sample[2] : '',
			'rating' => 5,
			'sample' => true,
		);
	}
}

if ( ! $wpwisebones_quotes ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-testimonials wpb-ind-section--alt" id="testimonials">
	<div class="container">
		<?php wpwisebones_industry_heading( $wpwisebones_section ); ?>
		<div class="row g-4">
			<?php foreach ( $wpwisebones_quotes as $wpwisebones_q ) : ?>
				<div class="col-md-4">
					<figure class="wpb-ind-card wpb-ind-quote-card<?php echo $wpwisebones_q['sample'] ? ' is-sample' : ''; ?>">
						<?php if ( $wpwisebones_q['sample'] ) : ?>
							<span class="wpb-ind-sample"><?php esc_html_e( 'Sample — visible to you only', 'wpwisebones' ); ?></span>
						<?php endif; ?>
						<?php if ( $wpwisebones_q['rating'] > 0 ) : ?>
							<?php /* translators: %d: rating out of five. */ ?>
							<div class="wpb-ind-stars" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %d out of 5', 'wpwisebones' ), min( 5, $wpwisebones_q['rating'] ) ) ); ?>">
								<?php echo esc_html( str_repeat( '★', min( 5, $wpwisebones_q['rating'] ) ) ); ?>
							</div>
						<?php endif; ?>
						<blockquote><p><?php echo esc_html( $wpwisebones_q['quote'] ); ?></p></blockquote>
						<figcaption><strong><?php echo esc_html( $wpwisebones_q['name'] ); ?></strong><?php if ( $wpwisebones_q['role'] ) : ?><span><?php echo esc_html( $wpwisebones_q['role'] ); ?></span><?php endif; ?></figcaption>
					</figure>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
