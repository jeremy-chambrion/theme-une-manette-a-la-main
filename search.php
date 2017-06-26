<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

global $wp_query;

get_header();
?>

<main id="main-content" class="container">
    <header class="page-header">
        <h1 class="page-title">
            <i class="fa fa-search" aria-hidden="true"></i>Résultat de recherche pour <u><?php echo get_search_query(); ?></u>
        </h1>
    </header><!-- .page-header -->

    <?php
    Theme\Unemanettealamain\Utils::get()
        ->printGridList($wp_query);

    get_template_part('template-parts/common/navigation', 'page');
    ?>
</main><!-- #main-content -->

<?php
get_sidebar();
get_footer();
