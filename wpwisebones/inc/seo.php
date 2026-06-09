<?php
/**
 * SEO meta tags â€” Open Graph, Twitter Card, Schema.org JSON-LD, canonical URL.
 *
 * Only active when a dedicated SEO plugin (Yoast, RankMath, AIOSEO) is NOT present.
 * Plugins hook into wp_head and add their own tags; we step aside for them.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'wpb_seo_meta', 2 );

function wpb_seo_meta() {
    // Yield to popular SEO plugins
    if (
        defined( 'WPSEO_VERSION' )       || // Yoast SEO
        defined( 'RANK_MATH_VERSION' )   || // RankMath
        defined( 'AIOSEO_VERSION' )      || // All in One SEO
        defined( 'SEOPRESS_VERSION' )       // SEOPress
    ) {
        return;
    }

    global $post;

    $site_name   = get_bloginfo( 'name' );
    $home_url    = home_url( '/' );
    $locale      = get_locale();

    /* â”€â”€ Gather page-specific data â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ( is_singular() && ! is_attachment() && isset( $post ) ) {
        $title       = get_the_title( $post );
        $description = wp_strip_all_tags( has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( get_the_content( null, false, $post ), 30 ) );
        $url         = get_permalink( $post );
        $og_type     = 'article';
        $image       = get_the_post_thumbnail_url( $post, 'wpb-hero' ) ?: get_site_icon_url( 512 );
        $author_name = get_the_author_meta( 'display_name', $post->post_author );
        $pub_date    = get_the_date( DATE_W3C, $post );
        $mod_date    = get_the_modified_date( DATE_W3C, $post );

        $tags = [];
        foreach ( (array) get_the_tags( $post ) as $tag ) {
            if ( $tag instanceof WP_Term ) {
                $tags[] = $tag->name;
            }
        }
    } elseif ( is_home() || is_front_page() ) {
        $title       = get_bloginfo( 'name' );
        $description = get_bloginfo( 'description' );
        $url         = $home_url;
        $og_type     = 'website';
        $image       = get_site_icon_url( 512 );
        $author_name = $pub_date = $mod_date = '';
        $tags        = [];
    } elseif ( is_archive() ) {
        $title       = get_the_archive_title();
        $description = wp_strip_all_tags( get_the_archive_description() );
        $url         = get_pagenum_link( 1 );
        $og_type     = 'website';
        $image       = get_site_icon_url( 512 );
        $author_name = $pub_date = $mod_date = '';
        $tags        = [];
    } elseif ( is_search() ) {
        /* translators: %s: search query */
        $title       = sprintf( __( 'Search: %s', 'wpwisebones' ), get_search_query() );
        $description = '';
        $url         = get_search_link( get_search_query() );
        $og_type     = 'website';
        $image       = '';
        $author_name = $pub_date = $mod_date = '';
        $tags        = [];
    } else {
        return; // Nothing useful to output for other pages
    }

    $title       = esc_attr( $title );
    $description = esc_attr( wp_trim_words( $description, 30 ) );
    $url         = esc_url( $url );
    $image       = $image ? esc_url( $image ) : '';

    /* â”€â”€ Canonical URL â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    echo '<link rel="canonical" href="' . $url . '">' . "\n";

    /* â”€â”€ Open Graph â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $og = [
        'og:site_name'   => esc_attr( $site_name ),
        'og:locale'      => esc_attr( $locale ),
        'og:type'        => esc_attr( $og_type ),
        'og:title'       => $title,
        'og:description' => $description,
        'og:url'         => $url,
    ];
    if ( $image )    $og['og:image']              = $image;
    if ( $pub_date ) $og['article:published_time'] = esc_attr( $pub_date );
    if ( $mod_date ) $og['article:modified_time']  = esc_attr( $mod_date );
    if ( $author_name ) $og['article:author']      = esc_attr( $author_name );
    foreach ( $tags as $tag ) {
        $og['article:tag'] = esc_attr( $tag );
    }

    foreach ( $og as $property => $content ) {
        if ( $content ) {
            echo '<meta property="' . esc_attr( $property ) . '" content="' . $content . '">' . "\n";
        }
    }

    /* â”€â”€ Twitter Card â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $twitter = [
        'twitter:card'        => $image ? 'summary_large_image' : 'summary',
        'twitter:title'       => $title,
        'twitter:description' => $description,
    ];
    if ( $image ) $twitter['twitter:image'] = $image;

    foreach ( $twitter as $name => $content ) {
        if ( $content ) {
            echo '<meta name="' . esc_attr( $name ) . '" content="' . $content . '">' . "\n";
        }
    }

    /* â”€â”€ Schema.org JSON-LD â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ( is_singular( 'post' ) && isset( $post ) ) {
        $schema = [
            '@context'         => 'https://schema.org',
            '@type'            => 'BlogPosting',
            'headline'         => get_the_title( $post ),
            'description'      => wp_strip_all_tags( get_the_excerpt( $post ) ),
            'url'              => get_permalink( $post ),
            'datePublished'    => get_the_date( DATE_W3C, $post ),
            'dateModified'     => get_the_modified_date( DATE_W3C, $post ),
            'author'           => [
                '@type' => 'Person',
                'name'  => get_the_author_meta( 'display_name', $post->post_author ),
                'url'   => get_author_posts_url( $post->post_author ),
            ],
            'publisher'        => [
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' ),
                'url'   => home_url( '/' ),
                'logo'  => [
                    '@type' => 'ImageObject',
                    'url'   => get_site_icon_url( 60 ) ?: home_url( '/favicon.ico' ),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => get_permalink( $post ),
            ],
        ];

        if ( has_post_thumbnail( $post ) ) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url'   => get_the_post_thumbnail_url( $post, 'wpb-hero' ),
            ];
        }

        if ( $tags ) {
            $schema['keywords'] = implode( ', ', $tags );
        }

        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
        echo "\n" . '</script>' . "\n";
    }

    // Website schema on front/home
    if ( is_front_page() || is_home() ) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => get_bloginfo( 'name' ),
            'url'      => home_url( '/' ),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => home_url( '/?s={search_term_string}' ),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
        echo "\n" . '</script>' . "\n";
    }
}
