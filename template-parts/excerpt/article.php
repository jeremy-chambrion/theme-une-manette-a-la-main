<?php
/**
 * Template part for displaying posts on homepage
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-excerpt ' . (is_sticky() ? 'article-sticky' : '')); ?>>
    <div class="row">
        <?php
        if (has_post_thumbnail()) {
            ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="entry-featured-container">
                <?php
                if (is_sticky()) {
                    echo '<span class="entry-ribbon entry-ribbon-sticky"><i class="fa fa-bookmark"></i>La sélection du moment</span>';
                }

                if (class_exists('acf')) {
                    $opinion = get_field('post-opinion-activate');
                    $feeling = get_field('post-opinion-feeling');

                    if (!empty($opinion) && !empty($feeling) && $feeling === 'awesome') {
                        echo '<span class="entry-ribbon entry-ribbon-fav"><i class="fa fa-heart"></i>Coup de cœur</span>';
                    }
                }

                echo get_the_post_thumbnail();
                ?>
            </a>
            <?php
        }
        ?>
        <div class="entry-body">
            <header class="entry-header">
                <?php
                get_template_part('template-parts/common/category');

                printf(
                    '<h2 class="entry-title"><a href="%s" rel="bookmark">%s</a></h2>',
                    esc_url(get_permalink()),
                    get_the_title()
                );
                ?>

            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>

            <footer class="entry-footer">
                <?php get_template_part('template-parts/common/information'); ?>
            </footer><!-- .entry-footer -->
        </div><!-- .article-content -->
    </div><!-- .row -->
</article>
