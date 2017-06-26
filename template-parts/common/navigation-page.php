<?php

if ($GLOBALS['wp_query']->max_num_pages > 1) {
    ?>
    <nav class="navigation">
        <h2 class="sr-only"><?php echo __('Posts navigation'); ?></h2>
        <div class="nav-links">
            <div class="previous">
                <?php previous_posts_link(__('Previous page')); ?>
            </div>
            <div class="next">
                <?php next_posts_link(__('Next page')); ?>
            </div>
        </div>
    </nav>
    <?php
}
