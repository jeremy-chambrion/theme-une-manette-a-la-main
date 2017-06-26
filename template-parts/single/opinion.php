<?php

/**
 * Template for opinion card at the end of the post
 */

// if ACF plugin not installed, do nothing
if (!class_exists('acf')) {
    return;
}

$opinion = get_field('post-opinion-activate');

// no opinion activated, do nothing
if (empty($opinion)) {
    return;
}

// get fields
$summary = get_field('post-opinion-summary');
$feeling = get_field('post-opinion-feeling');

// if no content, do nothing
if (empty($summary) && !have_rows('post-opinion-list-good') && !have_rows('post-opinion-list-bad')) {
    return;
}
?>


<div class="divider"></div>

<div class="entry-opinion">
    <h2 class="opinion-title">En résumé</h2>
    <div class="opinion-summary">
        <?php
        if (!empty($feeling)) {
            printf('<div class="opinion-icon %s"></div>', $feeling);
        }

        echo $summary;
        ?>
    </div>
    <div class="opinion-details row">
        <?php
        if (have_rows('post-opinion-list-good')) {
            ?>
            <div class="opinion-list-good col-xs-12 col-md-6">
                <h3>Les plus</h3>
                <ul>
                    <?php
                    while (have_rows('post-opinion-list-good')) {
                        the_row();
                        printf(
                            '<li>%s</li>',
                            get_sub_field('post-opinion-good')
                        );
                    }
                    ?>
                </ul>
            </div>
            <?php
        }

        if (have_rows('post-opinion-list-bad')) {
            ?>
            <div class="opinion-list-bad col-xs-12 col-md-6">
                <h3>Les moins</h3>
                <ul>
                    <?php
                    while (have_rows('post-opinion-list-bad')) {
                        the_row();
                        printf(
                            '<li>%s</li>',
                            get_sub_field('post-opinion-bad')
                        );
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>
</div>
