<?php
/**
 * Attachment / media file template.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$container = get_theme_mod( 'wpb_container_width', 'container' );
?>
<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <main id="primary" class="site-main col-12 py-4">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header mb-4">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-attachment mb-4 text-center">
                        <?php if ( wp_attachment_is_image() ) : ?>
                            <?php echo wp_get_attachment_image( get_the_ID(), 'full', false, [ 'class' => 'img-fluid rounded shadow' ] ); ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" class="btn btn-primary">
                                <i class="bi bi-download me-1"></i>
                                <?php esc_html_e( 'Download File', 'wpwisebones' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ( has_excerpt() ) : ?>
                        <div class="entry-caption text-muted mb-3"><?php the_excerpt(); ?></div>
                    <?php endif; ?>

                    <div class="entry-content"><?php the_content(); ?></div>

                    <?php
                    $parent_id = get_post()->post_parent;
                    if ( $parent_id ) :
                    ?>
                        <p class="mt-3">
                            <a href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>
                                <?php
                                /* translators: %s: parent post title */
                                printf( esc_html__( 'Back to: %s', 'wpwisebones' ), esc_html( get_the_title( $parent_id ) ) );
                                ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        </main>
    </div>
</div>
<?php get_footer(); ?>
