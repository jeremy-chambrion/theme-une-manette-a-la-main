<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 */

$bootstrap = Theme\Unemanettealamain\BootstrapTheme::get();

get_header();
?>

<main id="main-content" class="container">
    <?php
    // get sections to print from specific menu
    $menuLocations = get_nav_menu_locations();

    if (!empty($menuLocations['front-page-sections'])) {
        $sectionItems = wp_get_nav_menu_items($menuLocations['front-page-sections']);

        foreach ($sectionItems as $item) {
            switch ($item->object) {
            case 'page':
                if ($item->object_id === get_option('page_for_posts')) {
                    Theme\Unemanettealamain\Utils::get()
                        ->printFrontGridList(
                            Theme\Unemanettealamain\Utils::get()
                                ->getFrontLatestPosts(1, 4),
                            $item->title,
                            true,
                            'latest-posts',
                            'fa-rss',
                            $item->url
                        );
                }

                break;

            case 'category':
                Theme\Unemanettealamain\Utils::get()
                    ->printFrontGridList(
                        new WP_Query(
                            [
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'category__in' => $item->object_id
                            ]
                        ),
                        $item->title,
                        false,
                        'category-posts',
                        'fa-folder-o',
                        $item->url
                    );

                break;
            }
        }
    }
    ?>
</main><!-- #main-content -->

<?php
get_sidebar();
get_footer();
