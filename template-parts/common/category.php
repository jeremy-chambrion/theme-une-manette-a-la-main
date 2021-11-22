<?php

$primaryCategory = Theme\Unemanettealamain\Utils::get()
    ->getPrimaryCategoryId();

if (empty($primaryCategory)) {
    return;
}
?>

<div class="article-category text-uppercase">
    <?php echo get_cat_name($primaryCategory); ?>
</div>
