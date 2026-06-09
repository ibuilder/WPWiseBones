<?php
/**
 * Template Name: Landing Page
 * Template Post Type: page
 *
 * A page with no header/footer nav, ideal for marketing landing pages.
 * Add class "template-landing" to body via body_class.
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'template-landing' ); ?>>
<?php wp_body_open(); ?>

<main id="primary" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<?php wp_footer(); ?>
</body>
</html>
