<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that
 * contains both the current comments and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>
<section id="comments" class="container comments-area">
    <div class="divider"></div>
    <?php
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) {
        ?>
        <h2 class="comments-title">Commentaires</h2>
        <p class="no-comments">
            Les commentaires sont fermés
        </p>
    <?php
    } elseif (!have_comments()) {
        ?>
        <h2 class="comments-title">Commentaires</h2>
        <?php
    } else {
        printf(
            '<h2 class="comments-title">Commentaires <span class="comments-number badge">%s</span></h2>',
            number_format_i18n(get_comments_number())
        );
        ?>

        <ul class="comments-list">
            <?php wp_list_comments([ 'avatar_size' => 70]); ?>
        </ul>

        <?php
        get_template_part('template-parts/comments/navigation');
    }

    comment_form();
    ?>
</section><!-- #comments -->
