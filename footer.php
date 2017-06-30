<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
?>
    </div><!-- #content -->

    <footer id="footer" class="site-footer container-fluid">
        <div class="container">
            <ul class="site-info">
                <li><i class="fa fa-rocket" aria-hidden="true"></i>Propulsé par <a href="https://fr.wordpress.org/" rel="nofollow">WordPress</a></li>
                <li><i class="fa fa-users" aria-hidden="true"></i><a href="<?php echo esc_url(home_url('/a-propos/')); ?>" rel="nofollow">À propos</a></li>
                <li><i class="fa fa-gavel" aria-hidden="true"></i><a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>" rel="nofollow">Mentions légales</a></li>
            </ul><!-- .site-info -->
        </div>
    </footer><!-- #footer -->

    <div class="loader">
        <svg viewBox="0 0 32 32" width="32" height="32">
            <circle id="spinner" cx="16" cy="16" r="14" fill="none"></circle>
        </svg>
    </div>

    <?php wp_footer(); ?>

    <noscript>
        <style>
            #content, #footer {
                display: block;
                opacity: 1;
            }
            .loader {
                display: none;
            }
        </style>
    </noscript>
</div><!-- #page -->

</body>
</html>
