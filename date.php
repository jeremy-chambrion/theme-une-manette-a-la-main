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
        get_template_part('template-parts/common/breadcrumb');

        if (is_year()) {
            printf(
                '<h1 class="page-title"><i class="fa fa-calendar" aria-hidden="true"></i>Articles de <span class="info-title">%s</span></h1>',
                get_the_date(_x('Y', 'yearly archives date format'))
            );
        } elseif (is_month()) {
            printf(
                '<h1 class="page-title"><i class="fa fa-calendar" aria-hidden="true"></i>Articles de <span class="info-title">%s</span></h1>',
                get_the_date(_x('F Y', 'monthly archives date format'))
            );
        } elseif (is_day()) {
            printf(
                '<h1 class="page-title"><i class="fa fa-calendar" aria-hidden="true"></i>Articles du <span class="info-title">%s</span></h1>',
                get_the_date(_x('F j, Y', 'daily archives date format'))
            );
        } else {
            the_archive_title('<h1 class="page-title"><i class="fa fa-calendar" aria-hidden="true"></i>', '</h1>');
        }
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
