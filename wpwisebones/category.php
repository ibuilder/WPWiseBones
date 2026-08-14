<?php
/**
 * Category archive template.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
$o         = get_option( 'wpwisebones_options', array() );
if ( ! empty( $o['breadcrumbs'] ) ) {
	wpwisebones_breadcrumbs();
}
$category = get_queried_object();
?>
<div id="content" class="site-content">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="row g-4">

			<?php if ( wpwisebones_has_sidebar() && 'left-sidebar' === wpwisebones_get_layout() ) : ?>
				<aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
			<?php endif; ?>

			<main id="main" tabindex="-1" class="site-main <?php echo esc_attr( wpwisebones_content_class() ); ?>">
				<header class="page-header mb-4 pb-3 border-bottom">
					<div class="d-flex align-items-center gap-3 flex-wrap">
						<span class="badge bg-primary fs-6"><i class="bi bi-folder me-1"></i><?php single_cat_title(); ?></span>
						<span class="text-muted small">
							<?php
							printf(
								/* translators: %d: number of posts */
								esc_html( _n( '%d post', '%d posts', (int) $category->count, 'wpwisebones' ) ),
								(int) $category->count
							);
							?>
						</span>
					</div>
					<?php if ( category_description() ) : ?>
						<div class="mt-2 text-muted"><?php echo wp_kses_post( category_description() ); ?></div>
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
