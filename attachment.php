<?php
/**
 * Redirect attachment page to parent page
 */

if (!empty($post->guid)) {
    wp_redirect($post->guid);
} else {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
    exit();
}
