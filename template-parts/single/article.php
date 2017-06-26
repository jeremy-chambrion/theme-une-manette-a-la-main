<?php
/**
 * Template part for displaying post and page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

<article id="post-<?php the_ID(); ?>">
    <?php get_template_part('template-parts/single/header', 'hero'); ?>

    <div class="entry-content container">
        <?php
        the_content('');
        get_template_part('template-parts/single/tags');
        get_template_part('template-parts/single/opinion');
        ?>
    </div>
</article><!-- .post -->

<?php get_template_part('template-parts/single/related'); ?>
