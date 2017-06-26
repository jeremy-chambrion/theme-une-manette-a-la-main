<?php
/**
 * Template for header on the first page post
 */
?>

<header class="entry-header container" id="hero-content">
    <?php
    if (is_single()) {
        get_template_part('template-parts/common/breadcrumb');
        get_template_part('template-parts/common/information');
    }
    ?>

    <div class="row">
        <div class="entry-header-content col-xs-12 col-lg-8 col-lg-offset-2 text-center">
            <?php
            if (is_single()) {
                ?>
                <div class="entry-category-container">
                    <?php get_template_part('template-parts/common/category'); ?>
                </div>
                <?php
            }

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
        </div>
    </div>

    <div class="divider"></div>

    <?php
    if (is_single()) {
        get_template_part('template-parts/single/tldr');
    }
    ?>
</header>
