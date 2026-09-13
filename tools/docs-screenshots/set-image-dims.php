<?php
/**
 * Stamps every screenshot <img> in docs/*.html with its real pixel dimensions.
 *
 * The images are lazy-loaded, so without width/height the browser reserves no
 * space for them: the page reflows as they arrive and an anchor link lands in
 * the wrong place. Screenshots are captured at deviceScaleFactor 2, so the CSS
 * size is half the file's pixel size.
 *
 * Usage: php set-image-dims.php <docs-dir>
 *
 * @package WPWiseBones\Tools
 */

$docs = rtrim( $argv[1], '/' );

/* Captures taken at scale 1 rather than 2 — their CSS size is 1:1. */
$unscaled = static fn( string $file ): bool => (bool) preg_match( '/-full\.png$/', $file );

$total = 0;

foreach ( glob( "$docs/*.html" ) as $page ) {
	$html = (string) file_get_contents( $page );

	$html = preg_replace_callback(
		'/<img\s+([^>]*?)src="(assets\/img\/[^"]+)"([^>]*?)>/',
		static function ( array $m ) use ( $docs, $unscaled, &$total ): string {
			$attrs = $m[1] . $m[3];
			$size  = @getimagesize( "$docs/{$m[2]}" );

			if ( ! $size ) {
				return $m[0];
			}

			$divisor = $unscaled( $m[2] ) ? 1 : 2;
			$w       = (int) round( $size[0] / $divisor );
			$h       = (int) round( $size[1] / $divisor );

			// Drop any dimensions already present, then re-add the current ones.
			$attrs = preg_replace( '/\s*(width|height)="\d+"/', '', $attrs );
			$attrs = rtrim( ' ' . trim( $attrs ) );
			++$total;

			return '<img' . $attrs . ' src="' . $m[2] . '" width="' . $w . '" height="' . $h . '">';
		},
		$html
	);

	file_put_contents( $page, $html );
}

fwrite( STDOUT, "Stamped $total screenshot dimensions across " . count( glob( "$docs/*.html" ) ) . " pages\n" );
