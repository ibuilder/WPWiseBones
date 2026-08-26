<?php
/**
 * WooCommerce product loop card — AEC Forge.
 *
 * Overrides wpwisebones/woocommerce/content-product.php, which rendered the
 * thumbnail twice (its own the_post_thumbnail() call AND the default
 * woocommerce_before_shop_loop_item_title hook) once a product had a real
 * featured image. This version renders the image exactly once and falls back
 * to the branded placeholder for image-less listings.
 *
 * @package AEC_Forge
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'col', $product ); ?>>
	<div class="card h-100 border-0 shadow-sm product-card">

		<a href="<?php the_permalink(); ?>" class="product-card__img-link">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'card-img-top' ) );
			} else {
				printf(
					'<img src="%s" class="card-img-top af-placeholder" width="600" height="600" alt="%s" loading="lazy" decoding="async" />',
					esc_url( get_stylesheet_directory_uri() . '/assets/img/placeholder.svg' ),
					esc_attr( get_the_title() )
				);
			}
			?>
		</a>

		<div class="card-body d-flex flex-column">
			<h5 class="card-title fs-6 fw-semibold">
				<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none stretched-link">
					<?php the_title(); ?>
				</a>
			</h5>

			<p class="card-text text-primary fw-bold mb-2">
				<?php echo wp_kses_post( $product->get_price_html() ); ?>
			</p>

			<?php
			/* Vendor "sold by" line (AEC Market) lives on this hook; the default
			   price callback was removed in functions.php to avoid duplication. */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

			<div class="mt-auto">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		</div>

	</div>
</div>
