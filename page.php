<?php
/**
 * The template for displaying all page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();
?>

<main id="main-content" class="container">
    <header class="page-header">
        <h1 class="page-title">
            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php the_title(); ?>
        </h1>
    </header><!-- .page-header -->

    <?php
    if (have_posts()) {
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>">
            <div class="entry-content">
                <?php the_content(''); ?>
            </div>
        </article>

        <?php
        // if comments are open or we have at least one comment, load up the comment template
        if ((comments_open() || get_comments_number())) {
            comments_template();
        }
    } else {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part(404);
        exit();
    }
    ?>
</main><!-- #main-content -->

<?php
get_sidebar();
get_footer();
