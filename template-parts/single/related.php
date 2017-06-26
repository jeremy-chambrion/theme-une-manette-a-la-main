<?php

/**
 * Template for related posts with Jetpack in single post
 */

if (class_exists('Jetpack_RelatedPosts')) {
    printf(
        '<section id="related" class="container">%s</section>',
        do_shortcode('[jetpack-related-posts]')
    );
}
