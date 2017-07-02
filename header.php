<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo esc_attr(get_bloginfo('charset', 'display')); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#41d6c3">
    <meta name="application-name" content="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
    <meta name="msapplication-TileColor" content="#41d6c3" />
    <meta name="msapplication-starturl" content="<?php echo esc_url(home_url()); ?>" />
    <!--[if IE]>
    <meta http-equiv="imagetoolbar" content="no" />
    <![endif]-->
    <?php if (is_search()) { ?>
        <meta name="robots" content="noindex, nofollow" />
    <?php } ?>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://www.google-analytics.com" crossorigin />

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700|Roboto+Slab:300,700" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="skip-links">
    <a href="#content">Aller au contenu</a>
    <a href="#site-navigation">Aller au menu</a>
</div>

<div class="search-screen container-fluid">
    <div class="text-right">
        <a href="#" class="search-close" aria-label="Fermer">
            <i class="fa fa-close" aria-hidden="true"></i>
        </a>
    </div>
    <form class="row search-form" id="navbar-search" role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
        <div class="search-content text-center">
            <label class="sr-only" for="search-input">Rechercher</label>
            <input id="search-input" class="search-input" placeholder="Je recherche..." required="true" type="search" name="s">
            <button class="search-submit" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
    </form>
</div><!-- .search-screen -->

<div id="page" class="site">

    <header id="masthead" class="site-header hidden-print navbar navbar-fixed-top bg-primary container-fluid">
        <div class="row">
            <div class="site-logo col-sm-1 hidden-xs">
                <?php the_custom_logo(); ?>
            </div>
            <div class="masthead-content col-xs-12 col-sm-11">
                <div class="row" role="banner">
                    <div class="site-logo pull-left visible-xs-block">
                        <?php the_custom_logo(); ?>
                    </div>
                    <div class="site-branding pull-left" style="<?php $color = get_header_textcolor(); echo !empty($color) ? 'color: #' . $color : ''; ?>">
                        <?php
                        if (display_header_text()) {
                            printf('<span class="hidden-xs">%s</span>', get_bloginfo('name', 'display'));
                        }
                        ?>
                    </div>
                    <div class="site-links pull-right">
                        <ul>
                            <?php
                            $links = Theme\Unemanettealamain\Utils::get()
                                ->getSocialLinks();

                            foreach ($links as $class => $values) {
                                printf(
                                    '<li>
                                    <a href="%s" class="%s" aria-label="%s" title="%s">
                                        <i aria-hidden="true"></i><span class="site-links-title">%s</span>
                                    </a>
                                </li>',
                                    $values['url'],
                                    $class,
                                    $values['label'],
                                    $values['label'],
                                    $values['label']
                                );
                            }
                            ?>
                            <li>
                                <a href="#" class="search-open" aria-label="Recherche">
                                    <i class="fa fa-search" aria-hidden="true"></i><span class="site-links-title">Recherche</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <nav id="site-navigation" class="main-navigation">
                        <?php wp_nav_menu(
                            [
                                'theme_location' => 'primary',
                                'menu_id' => 'primary-menu'
                            ]
                        ); ?>
                    </nav><!-- #site-navigation -->
                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <div id="content" tabindex="-1">
