<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

global $wp_query;

get_header();
?>

<main id="main-content" class="container">
    <header class="page-header">
        <?php
        printf(
            '<h1 class="page-title">
                        <i class="fa fa-tag" aria-hidden="true"></i>Articles avec <span class="info-title">%s</span>
                    </h1>',
            single_tag_title('', false)
        );
        the_archive_description('<h3 class="page-subtitle">', '</h3>');
        ?>
    </header><!-- .page-header -->

    <?php
    Theme\Unemanettealamain\Utils::get()
        ->printGridList($wp_query);

    get_template_part('template-parts/common/navigation', 'date');
    ?>
</main><!-- #main-content -->

<?php
get_sidebar();
get_footer();
