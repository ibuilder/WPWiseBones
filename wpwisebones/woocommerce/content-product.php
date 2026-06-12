<?php
/**
 * WooCommerce product loop item — Bootstrap card.
 * Overrides: woocommerce/templates/content-product.php
 */
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
    return;
}
?>
<div <?php wc_product_class( 'col', $product ); ?>>
    <div class="card h-100 border-0 shadow-sm product-card">

        <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="product-card__img-link">
            <?php the_post_thumbnail( 'woocommerce_thumbnail', [ 'class' => 'card-img-top' ] ); ?>
        </a>
        <?php endif; ?>

        <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

        <div class="card-body d-flex flex-column">
            <h5 class="card-title fs-6 fw-semibold">
                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none stretched-link">
                    <?php the_title(); ?>
                </a>
            </h5>

            <p class="card-text text-primary fw-bold mb-2">
                <?php echo wp_kses_post( $product->get_price_html() ); ?>
            </p>

            <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

            <div class="mt-auto">
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>

    </div>
</div>
