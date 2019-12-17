<?php

/**
 * Template for tags in single post
 */

$tags = wp_get_post_tags(get_the_ID());

// if no tags found with current post, do nothing
if (empty($tags)) {
    return;
}
?>

<div class="article-tags">
    <?php
    foreach ($tags as $tag) {
        printf(
            '<a href="%s" rel="tag">%s</a>',
            get_tag_link($tag),
            $tag->name
        );
    }
    ?>
</div>
