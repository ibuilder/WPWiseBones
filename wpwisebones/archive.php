<?php defined( 'ABSPATH' ) || exit;
get_header(); ?>

<?php
$o         = get_option( 'wpwisebones_options', array() );
$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
if ( ! empty( $o['breadcrumbs'] ) ) {
	wpwisebones_breadcrumbs();
}
?>

<div id="content" class="site-content">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row g-4">

			<?php if ( wpwisebones_has_sidebar() && 'left-sidebar' === wpwisebones_get_layout() ) : ?>
				<aside id="secondary" class="col-lg-4 widget-area">
					<?php get_sidebar(); ?>
				</aside>
			<?php endif; ?>

			<main id="main" tabindex="-1" class="site-main <?php echo esc_attr( wpwisebones_content_class() ); ?>">
				<?php if ( have_posts() ) : ?>
					<header class="page-header mb-4">
						<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
						<?php the_archive_description( '<div class="archive-description text-muted">', '</div>' ); ?>
					</header>

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
				<aside id="secondary" class="col-lg-4 widget-area">
					<?php get_sidebar(); ?>
				</aside>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
