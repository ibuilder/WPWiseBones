<?php
/**
 * Installable web app: manifest, service worker and an offline page.
 *
 * @package Antivig\Child
 */

defined( 'ABSPATH' ) || exit;

/*
 * Served from the site root by query string rather than as theme files, because
 * a service worker only controls pages at or below its own URL: one under
 * /wp-content/themes/ could never see the board.
 *
 * What the worker does is deliberately small. It never stores a page. Member
 * pages are personal — a bet tracker, an account — and a cached copy is one that
 * can outlive a sign-out on a shared phone. Pages always come from the network;
 * only when the network is gone does the worker show a bundled offline page. The
 * icons and that page are the whole cache.
 */

/**
 * The manifest URL.
 *
 * @return string
 */
function antivig_pwa_manifest_url(): string {
	return add_query_arg( 'antivig_manifest', '1', home_url( '/' ) );
}

/**
 * The service worker URL.
 *
 * @return string
 */
function antivig_pwa_worker_url(): string {
	return add_query_arg( 'antivig_sw', '1', home_url( '/' ) );
}

/**
 * The offline page URL.
 *
 * @return string
 */
function antivig_pwa_offline_url(): string {
	return add_query_arg( 'antivig_offline', '1', home_url( '/' ) );
}

/**
 * An icon URL.
 *
 * @param string $file File name in assets/images.
 * @return string
 */
function antivig_pwa_icon( string $file ): string {
	return get_stylesheet_directory_uri() . '/assets/images/' . $file;
}

/**
 * Answer the three endpoints before WordPress builds a page.
 *
 * @return void
 */
function antivig_pwa_endpoints(): void {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- public, read-only endpoints.
	if ( isset( $_GET['antivig_manifest'] ) ) {
		antivig_pwa_send_manifest();
	}

	if ( isset( $_GET['antivig_sw'] ) ) {
		antivig_pwa_send_worker();
	}

	if ( isset( $_GET['antivig_offline'] ) ) {
		antivig_pwa_send_offline();
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended
}
add_action( 'init', 'antivig_pwa_endpoints', 1 );

/**
 * The web app manifest.
 *
 * @return void
 */
function antivig_pwa_send_manifest(): void {
	$manifest = array(
		'name'             => get_bloginfo( 'name' ),
		'short_name'       => get_bloginfo( 'name' ),
		'description'      => __( 'Fair prices with the bookmaker margin removed, the best line, and every pick on the record.', 'antivig-child' ),
		'id'               => '/',
		'start_url'        => wp_make_link_relative( home_url( '/today/' ) ),
		'scope'            => wp_make_link_relative( home_url( '/' ) ),
		'display'          => 'standalone',
		'background_color' => '#0E1A2B',
		'theme_color'      => '#0E1A2B',
		'icons'            => array(
			array(
				'src'   => antivig_pwa_icon( 'icon-192.png' ),
				'sizes' => '192x192',
				'type'  => 'image/png',
			),
			array(
				'src'   => antivig_pwa_icon( 'icon-512.png' ),
				'sizes' => '512x512',
				'type'  => 'image/png',
			),
			array(
				'src'     => antivig_pwa_icon( 'icon-maskable-512.png' ),
				'sizes'   => '512x512',
				'type'    => 'image/png',
				'purpose' => 'maskable',
			),
		),
	);

	nocache_headers();
	header( 'Content-Type: application/manifest+json; charset=utf-8' );
	echo wp_json_encode( $manifest, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	exit;
}

/**
 * The service worker.
 *
 * @return void
 */
function antivig_pwa_send_worker(): void {
	$cache    = 'antivig-shell-' . ANTIVIG_THEME_VERSION;
	$offline  = antivig_pwa_offline_url();
	$precache = array(
		$offline,
		antivig_pwa_icon( 'icon-192.png' ),
		antivig_pwa_icon( 'icon-512.png' ),
		antivig_pwa_icon( 'favicon.svg' ),
	);

	nocache_headers();
	header( 'Content-Type: application/javascript; charset=utf-8' );
	header( 'Service-Worker-Allowed: /' );

	$script = <<<'JS'
const CACHE = __CACHE__;
const OFFLINE = __OFFLINE__;
const PRECACHE = __PRECACHE__;

self.addEventListener( 'install', ( event ) => {
	event.waitUntil( caches.open( CACHE ).then( ( cache ) => cache.addAll( PRECACHE ) ).then( () => self.skipWaiting() ) );
} );

self.addEventListener( 'activate', ( event ) => {
	event.waitUntil(
		caches.keys()
			.then( ( keys ) => Promise.all( keys.filter( ( key ) => key.startsWith( 'antivig-shell-' ) && key !== CACHE ).map( ( key ) => caches.delete( key ) ) ) )
			.then( () => self.clients.claim() )
	);
} );

self.addEventListener( 'fetch', ( event ) => {
	const request = event.request;

	if ( request.method !== 'GET' ) {
		return;
	}

	const url = new URL( request.url );

	// Admin, sign-in and anything off-site are none of this worker's business.
	if ( url.origin !== self.location.origin || url.pathname.startsWith( '/wp-admin' ) || url.pathname.startsWith( '/wp-login' ) ) {
		return;
	}

	if ( request.mode === 'navigate' ) {
		// Pages always come from the network and are never stored.
		event.respondWith( fetch( request ).catch( () => caches.match( OFFLINE ) ) );
		return;
	}

	if ( PRECACHE.includes( request.url ) ) {
		event.respondWith( caches.match( request ).then( ( hit ) => hit || fetch( request ) ) );
	}
} );
JS;

	echo str_replace( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JavaScript response; every substituted value is JSON-encoded.
		array( '__CACHE__', '__OFFLINE__', '__PRECACHE__' ),
		array(
			wp_json_encode( $cache ),
			wp_json_encode( $offline, JSON_UNESCAPED_SLASHES ),
			wp_json_encode( $precache, JSON_UNESCAPED_SLASHES ),
		),
		$script
	);
	exit;
}

/**
 * The offline page: self-contained, so it renders with no network at all.
 *
 * @return void
 */
function antivig_pwa_send_offline(): void {
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'Cache-Control: public, max-age=86400' );
	?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php esc_html_e( 'Offline', 'antivig-child' ); ?> — <?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
<style>
	body { margin: 0; min-height: 100vh; display: grid; place-items: center; background: #0E1A2B; color: #E8EDF2; font: 16px/1.5 system-ui, -apple-system, "Segoe UI", sans-serif; }
	main { max-width: 32rem; padding: 2rem; text-align: center; }
	h1 { font-size: 1.5rem; margin: 1rem 0 .5rem; }
	p { color: #B3BFCC; margin: 0 0 1rem; }
	button { font: inherit; font-weight: 600; color: #0E1A2B; background: #F2A900; border: 0; border-radius: 6px; padding: .6rem 1.1rem; cursor: pointer; }
	img { width: 64px; height: 64px; }
	small { display: block; margin-top: 2rem; color: #8B9AAB; }
</style>
</head>
<body>
<main>
	<img src="<?php echo esc_url( antivig_pwa_icon( 'icon-192.png' ) ); ?>" alt="">
	<h1><?php esc_html_e( 'You are offline', 'antivig-child' ); ?></h1>
	<p><?php esc_html_e( 'Prices need a connection, and we never keep an old copy to show you instead: a price that may have moved is worse than no price at all.', 'antivig-child' ); ?></p>
	<button type="button" onclick="location.reload()"><?php esc_html_e( 'Try again', 'antivig-child' ); ?></button>
	<small><?php esc_html_e( 'Antivig takes no wagers. 21+. Gambling problem? Call 1-800-GAMBLER.', 'antivig-child' ); ?></small>
</main>
</body>
</html>
	<?php
	exit;
}

/**
 * Manifest, theme colour and touch icon in the head.
 *
 * @return void
 */
function antivig_pwa_head(): void {
	printf( '<link rel="manifest" href="%s">' . "\n", esc_url( antivig_pwa_manifest_url() ) );
	echo '<meta name="theme-color" content="#0E1A2B">' . "\n";
	printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( antivig_pwa_icon( 'apple-touch-icon.png' ) ) );
}
add_action( 'wp_head', 'antivig_pwa_head', 5 );

/**
 * Register the worker after the page has loaded, so it never slows the board.
 *
 * @return void
 */
function antivig_pwa_register(): void {
	printf(
		"<script>if('serviceWorker' in navigator){window.addEventListener('load',function(){navigator.serviceWorker.register(%s,{scope:'/'}).catch(function(){});});}</script>\n",
		wp_json_encode( wp_make_link_relative( antivig_pwa_worker_url() ) )
	);
}
add_action( 'wp_footer', 'antivig_pwa_register', 99 );
