<?php
/**
 * Stats strip under the hero. Figures and labels are edited in the
 * Customizer (Front Page Sections); the config only supplies placeholders.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_stats = wpwisebones_industry_stats();
if ( ! $wpwisebones_stats ) {
	return;
}
?>
<div class="wpb-ind-stats">
	<div class="container">
		<div class="row">
			<?php foreach ( $wpwisebones_stats as $wpwisebones_stat ) : ?>
				<div class="col-6 col-md-3 wpb-ind-stat">
					<b><?php echo esc_html( $wpwisebones_stat[0] ); ?></b>
					<span><?php echo esc_html( $wpwisebones_stat[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
