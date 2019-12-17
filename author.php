<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

global $wp_query;

$authorName = get_the_author();
$authorEmail = get_the_author_meta('email');
Theme\Unemanettealamain\LinkingData::get()
    ->addData(
        [
            '@type' => 'ProfilePage',
            'about' => [
                '@type' => 'Person',
                'name' => $authorName,
                'url' => get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nicename')),
                'image' => get_avatar_url($authorEmail)
            ]
        ]
    );

include_once ABSPATH . 'wp-admin/includes/plugin.php';

$authorMetas = [];

if (is_plugin_active('wordpress-seo/wp-seo.php')) {
    $url = get_the_author_meta('user_url');
    $relatedLinks = [];
    if (!empty($url)) {
        $authorMetas[] = sprintf(
            '<a href="%s" class="author-url url"><i class="fa fa-link" aria-label="Site internet"></i></a>',
            $url
        );
        $relatedLinks[] = $url;
    }

    $twitter = get_the_author_meta('twitter');
    if (!empty($twitter)) {
        $twitter = sprintf('https://twitter.com/%s', $twitter);
        $authorMetas[] = sprintf(
            '<a href="%s" class="author-twitter"><i class="fa fa-twitter" aria-label="Twitter"></i></a>',
            $twitter
        );
        $relatedLinks[] = $twitter;
    }

    $facebook = get_the_author_meta('facebook');
    if (!empty($facebook)) {
        $authorMetas[] = sprintf(
            '<a href="%s" class="author-facebook"><i class="fa fa-facebook-official" aria-label="Facebook"></i></a>',
            $facebook
        );
        $relatedLinks[] = $facebook;
    }

    $gplus = get_the_author_meta('googleplus');
    if (!empty($gplus)) {
        $authorMetas[] = sprintf(
            '<a href="%s" class="author-googleplus"><i class="fa fa-google-plus-official" aria-label="Google plus"></i></a>',
            $gplus
        );
        $relatedLinks[] = $gplus;
    }
    Theme\Unemanettealamain\LinkingData::get()
        ->addData(['relatedLink' => $relatedLinks]);
}

get_header();
?>

<main id="main-content" class="container">
    <header class="page-header">
        <div class="media">
            <div class="media-left">
                <?php echo get_avatar($authorEmail, 150, '', '', ['class' => 'u-photo photo']); ?>
            </div>
            <div class="media-body">
                <?php
                printf(
                    '<h1 class="page-title">%s</h1>',
                    $authorName
                );
                ?>
                <div class="author-links"><?php echo implode('', $authorMetas); ?></div>
            </div>
        </div>
        <?php the_archive_description('<h3 class="page-subtitle note">', '</h3>'); ?>
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
