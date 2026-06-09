<?php
/**
 * Sidebar template.
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( is_active_sidebar( 'sidebar-primary' ) ) : ?>
    <div class="sidebar-inner sticky-top" style="top: calc(var(--wpb-header-height, 72px) + 1rem)">
        <?php dynamic_sidebar( 'sidebar-primary' ); ?>
    </div>
<?php else : ?>
    <!-- Default sidebar content when no widgets are assigned -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php esc_html_e( 'About', 'wpwisebones' ); ?></h5>
            <p class="card-text text-muted small"><?php bloginfo( 'description' ); ?></p>
        </div>
    </div>
    <?php get_search_form(); ?>
<?php endif; ?>
