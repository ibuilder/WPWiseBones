<?php
/**
 * Template part: page.
 */
defined( 'ABSPATH' ) || exit;
$hide_title = get_post_meta( get_the_ID(), '_wpwisebones_hide_title', true );
$hero_img   = get_post_meta( get_the_ID(), '_wpwisebones_hero_image', true );
$hero_text  = get_post_meta( get_the_ID(), '_wpwisebones_hero_text', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( $hero_img ) : ?>
		<div class="entry-hero mb-4 rounded overflow-hidden" style="max-height:500px">
			<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" class="w-100 object-fit-cover">
		</div>
	<?php endif; ?>

	<header class="entry-header mb-4">
		<?php if ( ! $hide_title ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		<?php if ( $hero_text ) : ?>
			<p class="entry-subtitle lead text-muted mb-0"><?php echo esc_html( $hero_text ); ?></p>
		<?php endif; ?>
	</header>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">',
				'after'  => '</div>',
			)
		);
		?>
	</div>
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer mt-3">
			<a href="<?php echo esc_url( get_edit_post_link() ); ?>" class="btn btn-sm btn-outline-secondary">
				<i class="bi bi-pencil me-1"></i><?php esc_html_e( 'Edit Page', 'wpwisebones' ); ?>
			</a>
		</footer>
	<?php endif; ?>
</article>
