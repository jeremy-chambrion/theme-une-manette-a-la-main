<?php

/**
 * Template for opinion card at the end of the post
 */

// if ACF plugin not installed, do nothing
if (!class_exists('acf')) {
    return;
}

// get fields
$summary = get_field('post-review-summary');

// if no content, do nothing
if (empty($summary)) {
    return;
}
?>


<div class="divider"></div>

<div class="article-review hreview">
    <h2 class="review-title">En résumé</h2>
    <div class="review-summary row e-content">
        <div class="col-xs-12">
            <?php
            $feeling = get_field('post-review-feeling');
            if (!empty($feeling)) {
                printf('<div class="review-icon %s"></div>', $feeling);
            }

            echo $summary;
            ?>
        </div>
    </div>
    <div class="review-details row">
        <?php
        if (have_rows('post-review-list-good')) {
            ?>
            <div class="review-list-good col-xs-12 col-md-6">
                <h3>Les plus</h3>
                <ul>
                    <?php
                    while (have_rows('post-review-list-good')) {
                        the_row();
                        printf(
                            '<li>%s</li>',
                            get_sub_field('post-review-good')
                        );
                    }
                    ?>
                </ul>
            </div>
            <?php
        }

        if (have_rows('post-review-list-bad')) {
            ?>
            <div class="review-list-bad col-xs-12 col-md-6">
                <h3>Les moins</h3>
                <ul>
                    <?php
                    while (have_rows('post-review-list-bad')) {
                        the_row();
                        printf(
                            '<li>%s</li>',
                            get_sub_field('post-review-bad')
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
