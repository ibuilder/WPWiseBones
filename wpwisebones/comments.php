<?php
/**
 * Comments template â€“ Bootstrap-styled.
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) return;
?>

<div id="comments" class="comments-area mt-5">

    <?php if ( have_comments() ) : ?>
        <h3 class="comments-title mb-4">
            <?php
            $comment_count = get_comments_number();
            printf(
                /* translators: %s: number of comments */
                esc_html( _nx( '%s Response', '%s Responses', $comment_count, 'comments title', 'wpwisebones' ) ),
                number_format_i18n( $comment_count )
            );
            ?>
        </h3>

        <ol class="comment-list">
            <?php
            wp_list_comments( [
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'wpb_comment_callback',
            ] );
            ?>
        </ol>

        <?php the_comments_pagination( [
            'prev_text' => '<i class="bi bi-chevron-left"></i>',
            'next_text' => '<i class="bi bi-chevron-right"></i>',
        ] ); ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments alert alert-info"><?php esc_html_e( 'Comments are closed.', 'wpwisebones' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( [
        'title_reply'          => __( 'Leave a Reply', 'wpwisebones' ),
        'label_submit'         => __( 'Post Comment', 'wpwisebones' ),
        'comment_notes_before' => '',
        'class_submit'         => 'btn btn-primary',
        'class_form'           => 'comment-form',
        'fields'               => [
            'author' => '<div class="row g-3"><div class="col-md-4"><label for="author" class="form-label">' . __( 'Name', 'wpwisebones' ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" class="form-control" required></div>',
            'email'  => '<div class="col-md-4"><label for="email" class="form-label">' . __( 'Email', 'wpwisebones' ) . ' <span class="required">*</span></label><input id="email" name="email" type="email" class="form-control" required></div>',
            'url'    => '<div class="col-md-4"><label for="url" class="form-label">' . __( 'Website', 'wpwisebones' ) . '</label><input id="url" name="url" type="url" class="form-control"></div></div>',
        ],
        'comment_field' => '<div class="mt-3"><label for="comment" class="form-label">' . __( 'Comment', 'wpwisebones' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" rows="5" class="form-control" required></textarea></div>',
    ] );
    ?>
</div>

<?php
/**
 * Custom comment callback for Bootstrap styling.
 */
function wpb_comment_callback( WP_Comment $comment, array $args, int $depth ) {
    $GLOBALS['comment'] = $comment;
    $is_pingback = in_array( $comment->comment_type, [ 'pingback', 'trackback' ], true );
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'mb-3' ); ?>>
        <div class="comment-body card border-0 bg-light p-3 rounded">
            <div class="comment-author d-flex align-items-center gap-3 mb-2">
                <?php echo get_avatar( $comment, 48, '', '', [ 'class' => 'rounded-circle flex-shrink-0' ] ); ?>
                <div>
                    <strong class="fn d-block"><?php comment_author_link(); ?></strong>
                    <time datetime="<?php comment_date( DATE_W3C ); ?>" class="text-muted small">
                        <?php comment_date(); ?> <?php esc_html_e( 'at', 'wpwisebones' ); ?> <?php comment_time(); ?>
                    </time>
                </div>
                <?php comment_reply_link( array_merge( $args, [
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                    'reply_text' => '<i class="bi bi-reply me-1"></i>' . __( 'Reply', 'wpwisebones' ),
                    'class'      => 'ms-auto btn btn-sm btn-outline-secondary',
                ] ) ); ?>
            </div>
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <p class="alert alert-warning small py-1 px-2"><?php esc_html_e( 'Your comment is awaiting moderation.', 'wpwisebones' ); ?></p>
            <?php endif; ?>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
        </div>
    <?php
}
