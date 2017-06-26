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

    <?php wp_footer(); ?>
</div><!-- #page -->

</body>
</html>
