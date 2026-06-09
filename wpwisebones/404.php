<?php get_header(); ?>

<?php $container = get_theme_mod( 'wpb_container_width', 'container' ); ?>

<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <main id="primary" class="site-main text-center py-5">
            <div class="py-5">
                <h1 class="display-1 fw-bold text-primary">404</h1>
                <h2 class="mb-4"><?php esc_html_e( 'Page Not Found', 'wpwisebones' ); ?></h2>
                <p class="lead text-muted mb-4">
                    <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'wpwisebones' ); ?>
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <i class="bi bi-house me-1"></i><?php esc_html_e( 'Go Home', 'wpwisebones' ); ?>
                    </a>
                    <button onclick="history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i><?php esc_html_e( 'Go Back', 'wpwisebones' ); ?>
                    </button>
                </div>
                <div class="mt-5">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php get_footer(); ?>
