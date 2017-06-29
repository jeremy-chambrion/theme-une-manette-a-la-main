<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#404-not-found
 */

get_header();
?>

<main id="main-content" class="container text-center not-found">
    <h1>Page introuvable</h1>
    <div class="article-icon fa fa-exclamation-triangle"></div>
    <p>
        <strong>La page demandée n'a pas été trouvée.</strong>
    </p>
    <p>
        Vous pouvez revenir à la <a href="<?php echo home_url(); ?>">page d'accueil</a>
        ou utilisez <a href="#" class="search-open">la recherche</a> pour trouver ce que vous souhaitez.</p>
    </p>
</main><!-- #main-content -->

<?php
get_sidebar();
get_footer();
