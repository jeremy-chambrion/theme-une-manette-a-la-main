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

$thumbnaiInlineData = Theme\Unemanettealamain\Utils::get()->getThumbnailInlineData($imageHero);

if (!empty($thumbnaiInlineData)) {
    ?>
    <style>
        .entry-header .entry-hero .entry-hero-image {
            background: url(<?php echo $thumbnaiInlineData; ?>) no-repeat center;
            background-size: cover;
        }
    </style>
    <?php
}
?>

<header class="entry-header">
    <div class="entry-hero">
        <div class="entry-hero-image">
            <?php echo wp_get_attachment_image($imageHero['ID'], 'full'); ?>
        </div>
        <div class="entry-hero-container container">
            <div class="entry-hero-content text-center">
                <div class="entry-category-container">
                    <?php get_template_part('template-parts/common/category'); ?>
                </div>
                <?php
                the_title('<h1 class="entry-title">', '</h1>');

                if (class_exists('acf')) {
                    $subtitle = get_field('post-subtitle');

                    if (!empty($subtitle)) {
                        printf(
                            '<h2 class="entry-subtitle">%s</h2>',
                            $subtitle
                        );
                    }
                }
                ?>
                <a href="#main-content" class="btn btn-primary btn-action pulse pull-right" aria-hidden="true">
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
</header><!-- .entry-header -->
