<?php
/**
 * Template part: single post.
 */
defined( 'ABSPATH' ) || exit;
$wpwisebones_options    = get_option( 'wpwisebones_options', array() );
$wpwisebones_hide_title = get_post_meta( get_the_ID(), '_wpwisebones_hide_title', true );
$wpwisebones_hero_img   = get_post_meta( get_the_ID(), '_wpwisebones_hero_image', true );
$wpwisebones_hero_text  = get_post_meta( get_the_ID(), '_wpwisebones_hero_text', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( $wpwisebones_hero_img ) : ?>
		<div class="entry-hero mb-4 rounded overflow-hidden" style="max-height:500px">
			<img src="<?php echo esc_url( $wpwisebones_hero_img ); ?>" alt="<?php the_title_attribute(); ?>" class="w-100 object-fit-cover">
		</div>
	<?php elseif ( has_post_thumbnail() ) : ?>
		<div class="entry-hero mb-4 rounded overflow-hidden" style="max-height:500px">
			<?php the_post_thumbnail( 'wpwisebones-hero', array( 'class' => 'w-100 object-fit-cover' ) ); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header mb-4">
		<?php if ( ! $wpwisebones_hide_title ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		<?php if ( $wpwisebones_hero_text ) : ?>
			<p class="entry-subtitle lead text-muted mb-2"><?php echo esc_html( $wpwisebones_hero_text ); ?></p>
		<?php endif; ?>
		<div class="entry-meta text-muted small d-flex flex-wrap gap-2 mb-2">
			<?php
			wpwisebones_posted_on();
			wpwisebones_posted_by();
			?>
			<?php if ( ! empty( $wpwisebones_options['reading_time'] ) ) : ?>
				<span><i class="bi bi-clock me-1"></i><?php echo esc_html( wpwisebones_reading_time() ); ?></span>
			<?php endif; ?>
			<?php
			$wpwisebones_cats = get_the_category_list( ', ' );
			if ( $wpwisebones_cats ) {
				echo '<span><i class="bi bi-folder me-1"></i>' . wp_kses_post( $wpwisebones_cats ) . '</span>';
			}
			?>
		</div>
	</header>

	<div class="entry-content">
		<?php
		the_content( __( 'Continue reading...', 'wpwisebones' ) );
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'wpwisebones' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="entry-footer mt-4 pt-3 border-top">
		<?php wpwisebones_entry_footer(); ?>
		<?php
		if ( ! empty( $wpwisebones_options['social_share'] ) ) {
			wpwisebones_social_share();}
		?>
	</footer>
</article>
