<?php

$primaryCategory = Theme\Unemanettealamain\Utils::get()
    ->getPrimaryCategory();


if (empty($primaryCategory)) {
    return;
}
?>

<div class="entry-category text-uppercase">
    <?php echo get_cat_name($primaryCategory); ?>
</div>
