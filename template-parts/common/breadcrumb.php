<?php

$items = Theme\Unemanettealamain\Utils::get()
    ->getBreadcrumbItems(false);

if (empty($items)) {
    return;
}
?>

<ol class="breadcrumb">
    <li>
        <?php
        printf(
            '<a href="%s" aria-label="Accueil" title="Accueil"><i class="fa fa-home" aria-hidden="true"></i></a>',
            home_url()
        );
        ?>
    </li>
    <?php
    foreach ($items as $item) {
        printf(
            '<li>%s</li>',
            $item
        );
    }
    ?>
</ol>
