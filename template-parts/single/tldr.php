<?php
/**
 * Template for TL;DR in single page
 */

if (!class_exists('acf')) {
    return;
}

$tldr = get_field('post-tl-dr');

if (empty($tldr)) {
    return;
}
?>

<div class="article-tldr">
    <h3><abbr title="Too Long ; Didn't Read">TL;DR</abbr></h3>
    <div class="tldr-content p-summary entry-summary">
        <?php echo $tldr; ?>
        <div class="divider"></div>
    </div>
</div>
