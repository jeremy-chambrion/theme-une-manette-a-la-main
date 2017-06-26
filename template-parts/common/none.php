<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */
?>

<div class="no-results">
    <div class="page-content">
        <p>
            <strong><?php echo __('No posts found.'); ?></strong>
        </p>
        <p>
            <?php if (is_search()) { ?>
                Votre recherche ne retourne aucun résultat. Vous devriez essayer avec d'autres termes de recherche.
            <?php } elseif (is_category()) { ?>
                La catégorie est vide. Vous devriez utiliser <a href="#" class="search-open">la recherche</a> pour trouver ce que vous souhaitez.
            <?php } elseif (is_tag()) { ?>
                Le mot-clé n'est associé à aucun article. Vous devriez utiliser <a href="#" class="search-open">la recherche</a> pour trouver ce que vous souhaitez.
            <?php } else { ?>
                Vous devriez utiliser <a href="#" class="search-open">la recherche</a> pour trouver ce que vous souhaitez.
            <?php } ?>
        </p>
    </div><!-- .page-content -->
</div><!-- .no-results -->
