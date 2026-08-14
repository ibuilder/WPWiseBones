<?php
/**
 * Generic taxonomy archive template (custom taxonomies fall back here).
 */
defined( 'ABSPATH' ) || exit;
get_header();
$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
$o         = get_option( 'wpwisebones_options', array() );
if ( ! empty( $o['breadcrumbs'] ) ) {
	wpwisebones_breadcrumbs();
}
$term = get_queried_object(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- $term set from WP core function, used for taxonomy template context.
?>
<div id="content" class="site-content">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row g-4">

			<?php if ( wpwisebones_has_sidebar() && 'left-sidebar' === wpwisebones_get_layout() ) : ?>
				<aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
			<?php endif; ?>

			<main id="main" tabindex="-1" class="site-main <?php echo esc_attr( wpwisebones_content_class() ); ?>">
				<header class="page-header mb-4">
					<h1 class="page-title">
						<?php echo esc_html( $term->name ); ?>
						<small class="text-muted fs-6 ms-2"><?php echo esc_html( $term->taxonomy ); ?></small>
					</h1>
					<?php if ( $term->description ) : ?>
						<div class="archive-description text-muted"><?php echo wp_kses_post( $term->description ); ?></div>
					<?php endif; ?>
				</header>

				<?php if ( have_posts() ) : ?>
					<div class="row g-4">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
					<?php endwhile; ?>
					</div>
					<?php wpwisebones_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
				<?php endif; ?>
			</main>

			<?php if ( wpwisebones_has_sidebar() && 'right-sidebar' === wpwisebones_get_layout() ) : ?>
				<aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
