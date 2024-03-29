<?php
/**
 * Template part for displaying posts on homepage
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

<article <?php post_class('article-excerpt' . (is_sticky() ? ' article-sticky' : '')); ?>>
    <div class="row">
        <?php
        if (has_post_thumbnail()) {
            ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="article-featured-container" aria-hidden="true">
                <?php
                echo get_the_post_thumbnail(
                    null,
                    'post-thumbnail',
                    $args['thumbnail-attr'] ?? ''
                );

                if (is_sticky()) {
                    echo '<span class="article-ribbon article-ribbon-sticky"><i class="fa fa-bookmark"></i>La sélection du moment</span>';
                }

                if (class_exists('acf')) {
                    $feeling = get_field('post-review-feeling');

                    if (!empty($feeling) && $feeling === 'awesome') {
                        echo '<span class="article-ribbon article-ribbon-fav"><i class="fa fa-heart"></i>Coup de cœur</span>';
                    }
                }
                ?>
            </a>
            <?php
        }
        ?>
        <div class="article-body">
            <header class="article-header">
                <?php
                get_template_part('template-parts/common/category');

                printf(
                    '<h2 class="article-title entry-title"><a href="%s" rel="bookmark">%s</a></h2>',
                    esc_url(get_permalink()),
                    get_the_title()
                );
                ?>

            </header><!-- .article-header -->

            <div class="article-content article-summary entry-summary">
                <?php the_excerpt(); ?>
            </div>

            <footer class="article-footer">
                <?php get_template_part('template-parts/common/information'); ?>
            </footer><!-- .article-footer -->
        </div><!-- .article-content -->
    </div><!-- .row -->
</article>
