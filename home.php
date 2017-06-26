<?php
/**
 * The home template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
 */

global $paged;

get_header();
?>

<main id="main-content" class="container">
    <header class="page-header">
        <h1 class="page-title">
            <i class="fa fa-rss" aria-hidden="true"></i><?php echo __('Your latest posts'); ?>
        </h1>
    </header><!-- .page-header -->

    <?php
    Theme\Unemanettealamain\Utils::get()
        ->printGridList(
            new WP_Query(
                [
                    'post_type' => 'post',
                    'ignore_sticky_posts' => true,
                    'paged' => $paged
                ]
            )
        );

    get_template_part('template-parts/common/navigation', 'date');
    ?>
</main><!-- #main-content -->

<?php
get_sidebar();
get_footer();
