<?php

namespace Theme\Unemanettealamain;

require_once 'inc/Utils.php';
require_once 'inc/Entity.php';
require_once 'inc/LinkingData.php';

/**
 * Class BootstrapTheme
 *
 * @package Theme\Unemanettealamain
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */
class BootstrapTheme
{
    const VERSION_CSS = '20170627';
    const VERSION_JS = '20170627';

    /**
     * @var BootstrapTheme
     */
    private static $singleton;

    /**
     * Return singleton
     *
     * @return BootstrapTheme
     */
    public static function get()
    {
        if (is_null(self::$singleton)) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    /**
     * Initialize theme
     */
    public function init()
    {
        add_action('after_setup_theme', [$this, 'initThemeSupports']);
        add_action('after_setup_theme', [$this, 'initMenus']);
        add_action('after_setup_theme', [$this, 'initContentWidth'], 0);
        add_action('widgets_init', [$this, 'initWidgets']);
        add_action('wp_enqueue_scripts', [$this, 'initScripts']);
        add_action('wp_footer', [$this, 'addJsonLd'], 100);

        add_filter('wp_page_menu_args', [$this, 'initMenuArgs']);
        add_filter('mce_buttons', [$this, 'initEditorButtons'], 1, 2);
        add_filter('tiny_mce_before_init', [$this, 'initEditor']);
        add_filter('wp_link_pages_link', [$this, 'linkPagesLink'], 1, 2);
        add_filter('show_admin_bar', '__return_false');
        add_filter('pre_option_link_manager_enabled', '__return_true');
        add_filter('the_excerpt', [$this, 'the_excerpt']);
        add_filter('the_content', [$this, 'the_content']);
        add_filter('content_pagination', [$this, 'removePagination']);
        add_filter('embed_oembed_html', [$this, 'addEmbedContainer'], 10, 4);
        add_filter('image_size_names_choose', [$this, 'addMediaSizes']);
        add_filter('wp', [$this, 'removeJetpackRelatedPosts'], 20);
    }

    /**
     * Init the content width
     */
    public function initContentWidth()
    {
        if (!isset($GLOBALS['content_width'])) {
            $GLOBALS['content_width'] = 1920;
        }
    }

    /**
     * Init all theme supports
     */
    public function initThemeSupports()
    {
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(768, 384, true);
        add_image_size('post-thumbnail-small', 384, 192, true);
        add_image_size('post-thumbnail-large', 1200, 600, true);
        add_image_size('umalm-xsmall', 40, 40, false);
        add_image_size('umalm-xlarge', 1200, 1200, false);


        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', ['default-color' => 'ffffff']);

        // Set up the wordpress core custom header feature
        add_theme_support('custom-header');

        // Set up the wordpress core custom logo feature
        add_theme_support('custom-logo');

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']
        );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
    }

    /**
     * Init menus
     */
    public function initMenus()
    {
        // This theme uses wp_nav_menu() in one location.
        register_nav_menu('primary', 'Menu principal');
        register_nav_menu('front-page-sections', 'Rubriques principales');
    }

    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function initWidgets() {

        register_sidebar(
            [
                'name' => 'Sidebar Home',
                'id' => 'home-widget-area',
                'description' => 'Zone de widgets principale',
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget' => '</div></section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2><div class="widget-content">'
            ]
        );
    }

    /**
     * Init css and js
     */
    public function initScripts()
    {
        if (!is_admin()) {
            wp_enqueue_style(
                'bootstrap-style',
                get_stylesheet_uri(),
                [],
                self::VERSION_CSS
            );
            wp_enqueue_script(
                'bootstrap-script',
                get_template_directory_uri() . '/assets/js/bootstrap.js',
                ['jquery'],
                self::VERSION_JS,
                true
            );

            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        }
    }

    /**
     * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
     *
     * @param array $args
     * @return array
     */
    public function initMenuArgs(array $args)
    {
        $args['show_home'] = true;

        return $args;
    }

    /**
     * Init editor first buttons line
     * Removing page pagination button
     *
     * @param array $buttons
     * @param string $id
     * @return array
     */
    public function initEditorButtons(array $buttons, $id)
    {
        if ($id !== 'content') {
            return $buttons;
        }

        $index = array_search('wp_page', $buttons);

        if ($index !== false) {
            unset($buttons[$index]);
        }

        return $buttons;
    }

    /**
     * Init visual editor
     *
     * @param array $init
     * @return array
     */
    public function initEditor(array $init)
    {
        // Add elements not included in standard tinyMCE dropdown p,h1,h2,h3,h4,h5,h6
        $init["extended_valid_elements"] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width],small";

        // desactivation de la barre de chemin
        $init['statusbar'] = false;
        $init["theme_advanced_path"] = false;

        $init['block_formats'] = "Paragraphe=p;Titre=h3;Code=code";

        return $init;
    }

    /**
     * Get reading time for current post in minutes
     *
     * @param \WP_Post|null $post
     * @return int|null
     */
    public function getPostReadingTime(\WP_Post $post = null)
    {
        if (empty($post)) {
            $post = get_post();
        }

        if (empty($post->post_content)) {
            return null;
        }

        $content = apply_filters('the_content', $post->post_content);

        // get raw content without html tags
        $rawContent = strip_tags($content);

        // count words from raw content
        $wordCount = str_word_count($rawContent);

        if (empty($wordCount)) {
            return null;
        }

        // count number of minutes to read content
        $time = ceil($wordCount / 200);

        return $time;
    }

    /**
     * Return link for pages links
     *
     * @param string $link
     * @param int $position
     * @return string
     */
    public function linkPagesLink($link, $position)
    {
        global $page;

        if ($position < $page) {
            $link = sprintf(
                '<div class="previous">%s</div>',
                $link
            );
        } elseif ($position > $page) {
            $link = sprintf(
                '<div class="next">%s</div>',
                $link
            );
        }

        return $link;
    }

    /**
     * Return excerpt for current post
     *
     * @param string $excerpt
     * @return string
     */
    public function the_excerpt($excerpt)
    {
        if (!is_front_page()) {
            return $excerpt;
        }

        if(!class_exists('acf')) {
            return $excerpt;
        }

        $subtitle = get_field('post-subtitle');

        if (empty($subtitle)) {
            return $excerpt;
        }

        return sprintf(
            '<p>%s</p>',
            $subtitle
        );
    }

    /**
     * Return post content
     *
     * @param string $content
     * @return string
     */
    public function the_content($content)
    {
        if (!is_single()) {
            return $content;
        }

        $entity = new Entity();

        return $entity->getContent($content);
    }

    /**
     * Add container to embed object
     *
     * @param string $html
     * @param string $url
     * @param string $attr
     * @param int $post_id
     * @return string
     */
    public function addEmbedContainer($html, $url, $attr, $post_id) {
        if (!empty($url) && (strpos($url, 'youtube') !== false || strpos($url, 'youtu.be') !== false || strpos($url, 'dailymotion') !== false || strpos($url, 'vimeo') !== false)) {
            return sprintf(
                '<p class="video-container">%s</p>',
                $html
            );
        }

        return sprintf(
            '<p class="embed-container">%s</p>',
            $html
        );
    }

    /**
     * Return all pages glued together
     *
     * @param array $pages
     * @return array
     */
    public function removePagination(array $pages) {
        return [implode('', $pages)];
    }

    /**
     * Display Json-LD script in the footer
     */
    public function addJsonLd()
    {
        echo LinkingData::get()
            ->getJsonLdHtml();
    }

    /**
     * Add custom media sizes for using in dropdown media sizes
     *
     * @param array $sizes
     * @return array
     */
    public function addMediaSizes(array $sizes)
    {
        $lastSize = array_splice($sizes, -1, 1);
        $sizes = array_merge(
            $sizes,
            ['umalm-xlarge' => 'Très grande'],
            $lastSize
        );

        return $sizes;
    }

    /**
     * Remove the filter of Jetpack
     * inserting related posts at the end of the content
     */
    public function removeJetpackRelatedPosts()
    {
        if (class_exists( 'Jetpack_RelatedPosts')) {
            remove_filter(
                'the_content',
                [\Jetpack_RelatedPosts::init(), 'filter_add_target_to_dom'],
                40
            );
        }
    }
}

BootstrapTheme::get()
    ->init();
