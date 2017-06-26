<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

$tags = wp_get_post_tags(get_the_ID());
$relatedLinks = [];
foreach ($tags as $tag) {
    $relatedLinks[] = get_tag_link($tag);
}
Theme\Unemanettealamain\LinkingData::get()
    ->addData(['relatedLink' => $relatedLinks])
    ->addPost();

get_header();
?>

<main id="main-content">
    <?php
    if (have_posts()) {
        the_post();
        get_template_part('template-parts/single/article', get_post_format());

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
