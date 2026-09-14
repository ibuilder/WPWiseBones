<?php
/**
 * Date/time archive template.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$wpwisebones_container = get_theme_mod( 'wpwisebones_container_width', 'container' );
$wpwisebones_options   = get_option( 'wpwisebones_options', array() );
if ( ! empty( $wpwisebones_options['breadcrumbs'] ) ) {
	wpwisebones_breadcrumbs();
}

if ( is_year() ) {
	$wpwisebones_archive_title = get_the_date( 'Y' );
} elseif ( is_month() ) {
	$wpwisebones_archive_title = get_the_date( 'F Y' );
} elseif ( is_day() ) {
	$wpwisebones_archive_title = get_the_date( get_option( 'date_format' ) );
} else {
	$wpwisebones_archive_title = get_the_date();
}
?>
<div id="content" class="site-content">
	<div class="<?php echo esc_attr( $wpwisebones_container ); ?>">
		<div class="row g-4">

			<?php if ( wpwisebones_has_sidebar() && 'left-sidebar' === wpwisebones_get_layout() ) : ?>
				<aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
			<?php endif; ?>

			<main id="main" tabindex="-1" class="site-main <?php echo esc_attr( wpwisebones_content_class() ); ?>">
				<header class="page-header mb-4 pb-3 border-bottom">
					<h1 class="page-title">
						<i class="bi bi-calendar3 me-2 text-primary"></i>
						<?php echo esc_html( $wpwisebones_archive_title ); ?>
					</h1>
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
