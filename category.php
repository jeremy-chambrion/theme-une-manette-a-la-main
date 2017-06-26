<?php
/**
 * The template for displaying category pages
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
        printf(
            '<h1 class="page-title"><i class="fa fa-folder-open-o" aria-hidden="true"></i>Articles dans <span class="info-title">%s</span></h1>',
            single_cat_title('', false)
        );
        the_archive_description('<h3 class="page-subtitle">', '</h3>');

        // get sub categories
        if (!empty($cat)) {
            $subCategories = get_term_children($cat, 'category');

            if (!empty($subCategories)) {
                ?>
                <ol class="breadcrumb">
                    <li class="page-title"><i class="fa fa-sitemap" aria-hidden="true"></i><b>Sous-catégories</b></li>
                    <?php
                    $relatedLinks = [];
                    foreach ($subCategories as $id) {
                        $link = get_category_link($id);
                        printf(
                            '<li><a href="%s">%s</a></li>',
                            esc_url($link),
                            get_cat_name($id)
                        );
                        $relatedLinks[] = $link;
                    }
                    Theme\Unemanettealamain\LinkingData::get()
                        ->addData(['relatedLink' => $relatedLinks]);
                    ?>
                </ol>
                <?php
            }
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
