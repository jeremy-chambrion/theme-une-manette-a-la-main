<?php

if (get_comment_pages_count() > 1 && get_option('page_comments')) {
    ?>
    <nav class="navigation comment-nav">
        <h2 class="sr-only"><?php echo __('Comments navigation'); ?></h2>
        <div class="nav-links">
            <div class="previous">
                <?php next_comments_link('Commentaires plus récents'); ?>
            </div>
            <div class="next">
                <?php previous_comments_link('Commentaires plus anciens'); ?>
            </div>
        </div>
    </nav>
    <?php
}
