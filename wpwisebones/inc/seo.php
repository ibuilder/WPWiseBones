<?php
/**
 * SEO meta tags - Open Graph, Twitter Card, Schema.org JSON-LD, canonical URL.
 *
 * Only active when a dedicated SEO plugin (Yoast, RankMath, AIOSEO) is NOT present.
 * Plugins hook into wp_head and add their own tags; we step aside for them.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'wpwisebones_seo_meta', 2 );

/**
 * Trim text to a character budget at a word boundary, for the meta description.
 *
 * A search result and a link preview are not the same slot and do not have the
 * same room. Google shows roughly 155 characters of a meta description; Open
 * Graph consumers show appreciably more. This theme computed ONE 30-word string
 * and spent it on both, so every product page emitted a description of about
 * 200 characters that Google then cut again - and because the 30-word trim had
 * already appended its own ellipsis, the cut landed mid-sentence and the
 * ellipsis the theme added was never seen. og:description was fine at that
 * length; only the search snippet was over budget. So the two are budgeted
 * separately now.
 *
 * Entities are decoded before counting. The source text can already contain
 * them - wp_trim_words() appends &hellip;, and an apostrophe arrives as
 * &#039; - and those cost six characters inside the attribute while occupying
 * one on screen, so counting the encoded string budgets the wrong thing.
 * Whatever survives is re-encoded by esc_attr() at the point of output.
 *
 * @param string $text  Description text, encoded or not.
 * @param int    $limit Maximum characters, ellipsis included.
 * @return string
 */
function wpwisebones_seo_meta_description( $text, $limit = 155 ) {
	$text = html_entity_decode( (string) $text, ENT_QUOTES, 'UTF-8' );
	$text = trim( (string) preg_replace( '/\s+/u', ' ', $text ) );

	// Drop a trailing ellipsis from the source so we do not end up with two.
	$text = (string) preg_replace( '/\s*(\[\x{2026}\]|\x{2026}|\.\.\.)$/u', '', $text );

	if ( '' === $text || mb_strlen( $text ) <= $limit ) {
		return $text;
	}

	// One character of the budget belongs to the ellipsis we are about to add.
	$cut = mb_substr( $text, 0, $limit - 1 );

	// Back off to the last whole word, unless there is no space to back off to.
	if ( preg_match( '/^(.*)\s\S*$/su', $cut, $m ) && '' !== $m[1] ) {
		$cut = $m[1];
	}

	return rtrim( $cut, " \t,;:.-" ) . "\xE2\x80\xA6";
}

function wpwisebones_seo_meta() {
	// Yield to popular SEO plugins
	if (
		defined( 'WPSEO_VERSION' ) || // Yoast SEO
		defined( 'RANK_MATH_VERSION' ) || // RankMath
		defined( 'AIOSEO_VERSION' ) || // All in One SEO
		defined( 'SEOPRESS_VERSION' )       // SEOPress
	) {
		return;
	}

	global $post;

	$site_name = get_bloginfo( 'name' );
	$home_url  = home_url( '/' );
	$locale    = get_locale();

	/* -- Gather page-specific data --------------------------- */
	//
	// The front page is tested FIRST, and the order is the whole point.
	//
	// A static front page - Settings -> Reading -> "A static page" - satisfies
	// is_singular() as well as is_front_page(), so while is_singular() was
	// tested first the front-page branch below was unreachable on any site
	// configured that way. The homepage therefore advertised itself with
	// whatever get_the_title() returned, usually the literal word "Home", and
	// with the first 30 words of the page's stored content as its description.
	//
	// On a theme that renders the homepage from a template, that stored
	// content is a placeholder nobody expects a reader to see. ibuilder.me
	// shipped for days telling everyone who shared the link: "This page is
	// rendered by the iBuilder theme; this content is only a fallback shown if
	// the theme is switched away." That was the og:description, on the front
	// door of the site, in every Slack and LinkedIn preview.
	//
	// So: the tagline is the front page's description, because that is the one
	// field whose job is to describe the site. An explicitly written excerpt
	// is the fallback. Auto-trimmed page content is deliberately NOT a
	// fallback here - that is the behaviour being fixed.
	if ( is_front_page() ) {
		$title       = $site_name;
		$description = get_bloginfo( 'description' );

		if ( '' === trim( (string) $description ) && isset( $post ) && has_excerpt( $post ) ) {
			$description = wp_strip_all_tags( get_the_excerpt( $post ) );
		}

		$url         = $home_url;
		$og_type     = 'website';
		$image       = ( isset( $post ) && get_the_post_thumbnail_url( $post, 'wpwisebones-hero' ) )
			? get_the_post_thumbnail_url( $post, 'wpwisebones-hero' )
			: get_site_icon_url( 512 );
		$author_name = $pub_date = $mod_date = '';
		$tags        = array();
	} elseif ( is_singular() && ! is_attachment() && isset( $post ) ) {
		$title       = get_the_title( $post );
		$description = wp_strip_all_tags( has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( get_the_content( null, false, $post ), 30 ) );
		$url         = get_permalink( $post );
		$og_type     = 'article';
		$image       = get_the_post_thumbnail_url( $post, 'wpwisebones-hero' ) ? get_the_post_thumbnail_url( $post, 'wpwisebones-hero' ) : get_site_icon_url( 512 );
		$author_name = get_the_author_meta( 'display_name', $post->post_author );
		$pub_date    = get_the_date( DATE_W3C, $post );
		$mod_date    = get_the_modified_date( DATE_W3C, $post );

		$tags = array();
		foreach ( (array) get_the_tags( $post ) as $tag ) {
			if ( $tag instanceof WP_Term ) {
				$tags[] = $tag->name;
			}
		}
	} elseif ( is_home() ) {
		// The separate posts page, when the front page is static.
		$title       = get_bloginfo( 'name' );
		$description = get_bloginfo( 'description' );
		$url         = $home_url;
		$og_type     = 'website';
		$image       = get_site_icon_url( 512 );
		$author_name = $pub_date = $mod_date = '';
		$tags        = array();
	} elseif ( is_archive() ) {
		$title       = get_the_archive_title();
		$description = wp_strip_all_tags( get_the_archive_description() );
		$url         = get_pagenum_link( 1 );
		$og_type     = 'website';
		$image       = get_site_icon_url( 512 );
		$author_name = $pub_date = $mod_date = '';
		$tags        = array();
	} elseif ( is_search() ) {
		/* translators: %s: search query */
		$title       = sprintf( __( 'Search: %s', 'wpwisebones' ), get_search_query() );
		$description = '';
		$url         = get_search_link( get_search_query() );
		$og_type     = 'website';
		$image       = '';
		$author_name = $pub_date = $mod_date = '';
		$tags        = array();
	} else {
		return; // Nothing useful to output for other pages
	}

	// Kept before either trim, because the two consumers get different budgets.
	$raw_description = (string) $description;

	$title       = esc_attr( $title );
	$description = esc_attr( wp_trim_words( $raw_description, 30 ) );
	$url         = esc_url( $url );
	$image       = $image ? esc_url( $image ) : '';

	/**
	 * Filter the character budget for the meta description.
	 *
	 * @param int $limit Default 155, about what Google shows on desktop.
	 */
	$meta_description = wpwisebones_seo_meta_description(
		$raw_description,
		(int) apply_filters( 'wpwisebones_meta_description_length', 155 )
	);

	/* -- Meta description ------------------------------------ */
	//
	// This function computed $description and then spent it entirely on
	// og:description and twitter:description. The plain meta description -
	// the only one of the three a search engine actually reads, and the text
	// that appears under the result in Google - was never emitted at all, on
	// any page, on any site built with this theme.
	//
	// Leaving it out does not break a page, which is why it went unnoticed:
	// Google falls back to assembling a snippet out of the page body, so the
	// result looks fine and simply is not the sentence anyone chose.
	if ( $meta_description ) {
		echo '<meta name="description" content="' . esc_attr( $meta_description ) . '">' . "\n";
	}

	/* -- Open Graph ------------------------------------------ */
	$og = array(
		'og:site_name'   => esc_attr( $site_name ),
		'og:locale'      => esc_attr( $locale ),
		'og:type'        => esc_attr( $og_type ),
		'og:title'       => $title,
		'og:description' => $description,
		'og:url'         => $url,
	);
	if ( $image ) {
		$og['og:image'] = $image;
	}
	if ( $pub_date ) {
		$og['article:published_time'] = esc_attr( $pub_date );
	}
	if ( $mod_date ) {
		$og['article:modified_time'] = esc_attr( $mod_date );
	}
	if ( $author_name ) {
		$og['article:author'] = esc_attr( $author_name );
	}
	foreach ( $og as $property => $content ) {
		if ( $content ) {
			echo '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $content ) . '">' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literal closing tag chars, not dynamic data.
		}
	}

	// article:tag is repeated once per tag, which is why it cannot live in
	// $og: that is a key => value map, so assigning 'article:tag' inside a
	// loop overwrote the previous tag every time and a post with five tags
	// emitted exactly one - the last one. Emitted here instead, after the map.
	foreach ( $tags as $tag ) {
		echo '<meta property="article:tag" content="' . esc_attr( $tag ) . '">' . "\n";
	}

	/* -- Twitter Card -------------------------------------------------------- */
	$twitter = array(
		'twitter:card'        => $image ? 'summary_large_image' : 'summary',
		'twitter:title'       => $title,
		'twitter:description' => $description,
	);
	if ( $image ) {
		$twitter['twitter:image'] = $image;
	}

	foreach ( $twitter as $name => $content ) {
		if ( $content ) {
			echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $content ) . '">' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literal closing tag chars, not dynamic data.
		}
	}

	/* -- Schema.org JSON-LD ---------------------------------- */
	if ( is_singular( 'post' ) && isset( $post ) ) {
		$schema = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title( $post ),
			'description'      => wp_strip_all_tags( get_the_excerpt( $post ) ),
			'url'              => get_permalink( $post ),
			'datePublished'    => get_the_date( DATE_W3C, $post ),
			'dateModified'     => get_the_modified_date( DATE_W3C, $post ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', $post->post_author ),
				'url'   => get_author_posts_url( $post->post_author ),
			),
			'publisher'        => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
				'logo'  => array(
					'@type' => 'ImageObject',
					'url'   => get_site_icon_url( 60 ) ? get_site_icon_url( 60 ) : home_url( '/favicon.ico' ),
				),
			),
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => get_permalink( $post ),
			),
		);

		if ( has_post_thumbnail( $post ) ) {
			$schema['image'] = array(
				'@type' => 'ImageObject',
				'url'   => get_the_post_thumbnail_url( $post, 'wpwisebones-hero' ),
			);
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
		$schema = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'WebSite',
			'name'            => get_bloginfo( 'name' ),
			'url'             => home_url( '/' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => home_url( '/?s={search_term_string}' ),
				),
				'query-input' => 'required name=search_term_string',
			),
		);
		echo '<script type="application/ld+json">' . "\n";
		echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		echo "\n" . '</script>' . "\n";
	}
}
