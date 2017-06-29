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
    <button class="btn btn-default tldr-title tldr-closed" title="Too Long ; Didn't Read. Afficher le résumé du texte de l'article.">TL;DR</button>
    <div class="tldr-content p-summary entry-summary">
        <?php echo $tldr; ?>

        <div class="divider"></div>
    </div>
</div>
