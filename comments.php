<?php
/**
 * The template for displaying comments
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area my-8">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>
        <h2 class="comments-title text-xl font-bold mb-4">
            <?php
            $transpro_comment_count = get_comments_number();
            if ('1' === $transpro_comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'transpro'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $transpro_comment_count, 'comments title', 'transpro')),
                    number_format_i18n($transpro_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list pl-0 list-none">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 60,
                    'reply_text' => esc_html__('Reply', 'transpro'),
                )
            );
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note.
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'transpro'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().

    comment_form(
        array(
            'class_form'         => 'comment-form bg-gray-50 p-4 rounded',
            'title_reply'        => esc_html__('Leave a Comment', 'transpro'),
            'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title text-lg font-bold">',
            'title_reply_after'  => '</h3>',
            'submit_button'      => '<input type="submit" name="%1$s" id="%2$s" class="%3$s bg-blue-500 hover:bg-blue-600 text-white cursor-pointer px-4 py-2 rounded" value="%4$s" />',
        )
    );
    ?>

</div><!-- #comments -->