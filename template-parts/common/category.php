<?php

$primaryCategory = Theme\Unemanettealamain\Utils::get()
    ->getPrimaryCategory();


if (empty($primaryCategory)) {
    return;
}
?>

<div class="article-category text-uppercase p-category">
    <?php echo get_cat_name($primaryCategory); ?>
</div>
