<?php
/**
 * Latest blog posts — market updates, project news, homeowner guides.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_query   = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	)
);
if ( ! $wpwisebones_query->have_posts() ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-posts" id="insights">
	<div class="container">
		<?php wpwisebones_industry_heading( $wpwisebones_section ); ?>
		<div class="row g-4">
			<?php
			while ( $wpwisebones_query->have_posts() ) :
				$wpwisebones_query->the_post();
				?>
				<div class="col-md-4">
					<article class="wpb-ind-card wpb-ind-post">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="wpb-ind-media"><?php the_post_thumbnail( 'wpwisebones-card', array( 'class' => 'wpb-ind-media__img' ) ); ?></div>
						<?php endif; ?>
						<div class="wpb-ind-card__body">
							<p class="wpb-ind-post__date"><?php echo esc_html( get_the_date() ); ?></p>
							<h3 class="wpb-ind-card__title"><a class="stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						</div>
					</article>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();
