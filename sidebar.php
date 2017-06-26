<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

if (is_active_sidebar('home-widget-area')) {
    ?>
    <aside id="secondary" class="container-fluid" role="complementary">
        <div class="container">
            <div class="row">
                <?php dynamic_sidebar('home-widget-area'); ?>
            </div>
        </div>
    </aside><!-- #secondary -->
    <?php
}
