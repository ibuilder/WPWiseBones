<?php
/**
 * Team grid from the Industry Kit's Team entries. Hidden until there are any.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_people  = wpwisebones_industry_items( 'team', isset( $wpwisebones_section['count'] ) ? absint( $wpwisebones_section['count'] ) : 4 );
if ( ! $wpwisebones_people ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-team" id="team">
	<div class="container">
		<?php wpwisebones_industry_heading( $wpwisebones_section ); ?>
		<div class="row g-4 justify-content-center">
			<?php foreach ( $wpwisebones_people as $wpwisebones_person ) : ?>
				<?php
				$wpwisebones_role    = wpwisebones_industry_meta( $wpwisebones_person->ID, 'role' );
				$wpwisebones_license = wpwisebones_industry_meta( $wpwisebones_person->ID, 'license' );
				?>
				<div class="col-sm-6 col-lg-3">
					<article class="wpb-ind-card wpb-ind-person text-center">
						<div class="wpb-ind-person__photo">
							<?php if ( has_post_thumbnail( $wpwisebones_person ) ) : ?>
								<?php echo get_the_post_thumbnail( $wpwisebones_person, 'thumbnail', array( 'class' => 'rounded-circle' ) ); ?>
							<?php else : ?>
								<span class="wpb-ind-avatar" aria-hidden="true"><?php echo esc_html( mb_strtoupper( mb_substr( get_the_title( $wpwisebones_person ), 0, 1 ) ) ); ?></span>
							<?php endif; ?>
						</div>
						<h3 class="wpb-ind-card__title"><a class="stretched-link" href="<?php echo esc_url( get_permalink( $wpwisebones_person ) ); ?>"><?php echo esc_html( get_the_title( $wpwisebones_person ) ); ?></a></h3>
						<?php if ( $wpwisebones_role ) : ?>
							<p class="wpb-ind-person__role"><?php echo esc_html( $wpwisebones_role ); ?></p>
						<?php endif; ?>
						<?php if ( $wpwisebones_license ) : ?>
							<p class="wpb-ind-person__license"><?php echo esc_html( $wpwisebones_license ); ?></p>
						<?php endif; ?>
					</article>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
