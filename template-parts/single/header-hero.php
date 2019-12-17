<?php
/**
 * Template for hero header on post
 */

if (!class_exists('acf')) {
    get_template_part('template-parts/single/header', 'default');

    return;
}

$imageHero = get_field('post-hero-background-image');

if (empty($imageHero['ID'])) {
    get_template_part('template-parts/single/header', 'default');

    return;
}

$thumbnaiInlineData = Theme\Unemanettealamain\Utils::get()->getThumbnailInlineData($imageHero['ID']);

if (!empty($thumbnaiInlineData)) {
    ?>
    <style>
        .article-header .article-hero .article-hero-image {
            background: url(<?php echo $thumbnaiInlineData; ?>) no-repeat center;
            background-size: cover;
        }
    </style>
    <?php
}
?>

<header class="article-header">
    <div class="article-hero">
        <div class="article-hero-image">
            <?php echo wp_get_attachment_image($imageHero['ID'], 'full'); ?>
        </div>
        <div class="article-hero-container container">
            <div class="article-hero-content text-center">
                <div class="article-category-container">
                    <?php get_template_part('template-parts/common/category'); ?>
                </div>
                <?php
                the_title('<h1 class="article-title entry-title">', '</h1>');

                if (class_exists('acf')) {
                    $subtitle = get_field('post-subtitle');

                    if (!empty($subtitle)) {
                        printf(
                            '<h2 class="article-subtitle">%s</h2>',
                            $subtitle
                        );
                    }
                }
                ?>
                <a href="#under-hero-content" class="btn btn-primary btn-action pulse pull-right" aria-hidden="true">
                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="container" id="under-hero-content">
        <?php
        get_template_part('template-parts/common/breadcrumb');
        get_template_part('template-parts/common/information');
        ?>

        <?php get_template_part('template-parts/single/tldr'); ?>
    </div>
</header><!-- .article-header -->
