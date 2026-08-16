<?php
/**
 * Template Name: RealWise Marketing
 * Template Post Type: page
 *
 * Header + footer chrome, but the page content is output edge-to-edge (no
 * container/sidebar wrapper) so full-bleed RealWise sections render correctly.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main rw-marketing">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>
<?php
get_footer();
