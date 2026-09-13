<?php
/**
 * Fills the generated block of docs/shortcodes.html from the manifest that
 * render-shortcodes.php writes, so the documented usage, attributes and
 * screenshots always come from the plugin source.
 *
 * Usage: php build-shortcodes-page.php <build-dir> <docs-dir>
 *
 * @package WPWiseBones\Tools
 */

$build = rtrim( $argv[1], '/' );
$docs  = rtrim( $argv[2], '/' );
$page  = "$docs/shortcodes.html";

$manifest = json_decode( (string) file_get_contents( "$build/shortcodes.json" ), true );
if ( ! $manifest ) {
	fwrite( STDERR, "Cannot read $build/shortcodes.json\n" );
	exit( 1 );
}

$e = static fn( $s ) => htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' );

$nav  = '';
$body = '';

foreach ( $manifest as $sc ) {
	$nav .= "\t\t<a href=\"#{$sc['slug']}\">" . $e( $sc['title'] ) . "</a>\n";

	$rows = '';
	foreach ( $sc['atts'] as $group ) {
		foreach ( $group as $att ) {
			$note  = $att['note'] ? '<br><span style="color:var(--text-faint)">' . $e( $att['note'] ) . '</span>' : '';
			$rows .= "\t\t\t\t\t<tr><td><code>" . $e( $att['name'] ) . '</code></td><td><code>' . $e( $att['default'] ) . "</code>$note</td></tr>\n";
		}
	}
	$table = $rows
		? "\t\t\t\t<div class=\"table-scroll\">\n\t\t\t\t<table>\n\t\t\t\t\t<thead><tr><th>Attribute</th><th>Default</th></tr></thead>\n\t\t\t\t\t<tbody>\n$rows\t\t\t\t\t</tbody>\n\t\t\t\t</table>\n\t\t\t\t</div>\n"
		: '';

	$body .= <<<HTML
		<section class="sc-item" id="{$sc['slug']}">
			<div class="sc-head">
				<h3>{$e( $sc['title'] )}</h3>
				<code>[{$sc['tag']}]</code>
			</div>
			<p>{$e( $sc['blurb'] )}</p>
			<div class="sc-body">
				<div class="shot"><img src="assets/img/sc-{$sc['slug']}.png" alt="Rendered output of the {$e( $sc['title'] )} shortcode." loading="lazy"></div>
				<div class="snippet"><pre><code>{$e( $sc['code'] )}</code></pre></div>
			</div>
$table		</section>

HTML;
}

$html = (string) file_get_contents( $page );

foreach ( array( 'NAV' => $nav, 'BODY' => $body ) as $marker => $content ) {
	$start   = "<!-- GENERATED:$marker:START -->";
	$end     = "<!-- GENERATED:$marker:END -->";
	$pattern = '/' . preg_quote( $start, '/' ) . '.*?' . preg_quote( $end, '/' ) . '/s';
	if ( ! preg_match( $pattern, $html ) ) {
		fwrite( STDERR, "Marker $marker missing from $page\n" );
		exit( 1 );
	}
	$html = preg_replace( $pattern, $start . "\n" . $content . $end, $html );
}

file_put_contents( $page, $html );
fwrite( STDOUT, 'Wrote ' . count( $manifest ) . " shortcode entries → $page\n" );
