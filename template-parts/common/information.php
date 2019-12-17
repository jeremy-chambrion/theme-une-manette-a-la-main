<?php
$avatarHtml = get_avatar(get_the_author_meta('email'));
?>

<div class="article-info media">
    <div class="media-left">
        <?php echo $avatarHtml; ?>
    </div>
    <div class="media-body">
        <div class="article-author author">
            <?php
            printf(
                'Par <a href="%s" class="url" rel="author">%s</a>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nicename'))),
                get_the_author()
            );
            ?>
        </div>
        <div class="article-time">
            <?php
            $publicationDate = get_post_time('c', true);
            printf(
                '<time class="dt-updated updated" datetime="%s" title="%s" pubdate="%s">Le %s à %s</time>',
                esc_attr($publicationDate),
                esc_attr($publicationDate),
                esc_attr($publicationDate),
                get_the_date(),
                get_the_time()
            );
            ?>
        </div>
        <?php
        $readingTime = Theme\Unemanettealamain\BootstrapTheme::get()
            ->getPostReadingTime();

        if (!empty($readingTime)) {
            printf(
                '<div class="article-reading"><i class="fa fa-clock-o" aria-hidden="true"></i> %d min. de lecture</div>',
                $readingTime
            );
        }
        ?>
    </div>
    <div class="media-right">
        <?php echo $avatarHtml; ?>
    </div>
</div><!-- .article-info -->
