<?php
/**
 * Custom Bootstrap 5 search form.
 * Replaces WordPress's default get_search_form() output.
 */
defined( 'ABSPATH' ) || exit;

$unique_id = esc_attr( uniqid( 'search-form-' ) );
?>
<form role="search" method="get" class="search-form d-flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo $unique_id; ?>" class="visually-hidden">
        <?php esc_html_e( 'Search for:', 'wpwisebones' ); ?>
    </label>
    <input
        type="search"
        id="<?php echo $unique_id; ?>"
        class="search-field form-control"
        placeholder="<?php esc_attr_e( 'Search&hellip;', 'wpwisebones' ); ?>"
        value="<?php echo esc_attr( get_search_query() ); ?>"
        name="s"
    >
    <button type="submit" class="search-submit btn btn-primary ms-1" aria-label="<?php esc_attr_e( 'Search', 'wpwisebones' ); ?>">
        <i class="bi bi-search"></i>
    </button>
</form>
