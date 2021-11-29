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
    const SCRIPTS_ASYNC = [
        'bootstrap-script',
        'lazysizes-script',
        'devicepx',
        'jetpack_related-posts',
        'wp-embed',
        'comment-reply'
    ];

    const SCRIPTS_DEFER = [];

    /**
     * @var BootstrapTheme
     */
    private static $singleton;

    /** @var string[] */
    private $inlineStyles = [];

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
        add_action('wp_enqueue_scripts', [$this, 'initStyles']);
        add_action('wp_enqueue_scripts', [$this, 'initScripts']);
        add_action('style_loader_tag', [$this, 'transformLinkStylesheet']);
        add_action('wp_head', [$this, 'initServiceWorker']);
        add_action('wp_head', [$this, 'addInlinedStyles'], 2);
        add_action('wp_footer', [$this, 'addJsonLd'], 100);
        add_action('acf/init', [$this, 'initAcf']);

        add_filter('wp_page_menu_args', [$this, 'initMenuArgs']);
        add_filter('mce_buttons', [$this, 'initEditorButtons'], 1, 2);
        add_filter('tiny_mce_before_init', [$this, 'initEditor']);
        add_filter('wp_link_pages_link', [$this, 'linkPagesLink'], 1, 2);
        add_filter('show_admin_bar', '__return_false');
        add_filter('pre_option_link_manager_enabled', '__return_true');
        add_filter('the_content', [$this, 'the_content'], 10, 2);
        add_filter('content_pagination', [$this, 'removePagination']);
        add_filter('embed_oembed_html', [$this, 'addEmbedContainer'], 99);
        add_filter('video_embed_html', [$this, 'addEmbedContainer'], 99);
        add_filter('oembed_result', [$this, 'addEmbedContainer'], 99);
        add_filter('image_size_names_choose', [$this, 'addMediaSizes']);
        add_filter('wp', [$this, 'removeJetpackRelatedPosts'], 20);
        add_filter('script_loader_tag', [$this, 'addAsyncAttribute'], 10, 2);
        add_filter('wp_default_scripts', [$this, 'removeJqueryMigrate']);
        add_filter('wpseo_json_ld_output', [$this, 'removeYoastJson']);
        add_filter('wp_get_attachment_image_attributes', [$this, 'addAttachmentImageLazyload'], 200);
        add_filter('the_content', [$this, 'addImgLazyload'], 200, 2);
        add_filter('the_content', [$this, 'addMiscLazyload'], 200, 2);
        add_filter('widget_text', [$this, 'addImgLazyload'], 200);
        add_filter('get_avatar', [$this, 'addImgLazyload'], 200);
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

    public function initStyles()
    {
        if (!is_admin()) {
            if (is_front_page()) {
                $this->inlineStyles[] = \Theme\Unemanettealamain\Utils::get()->getCriticalCss('home-critical.css');
            } elseif (is_home()) {
                $this->inlineStyles[] = \Theme\Unemanettealamain\Utils::get()->getCriticalCss('latest-critical.css');
            } elseif (is_category()) {
                $this->inlineStyles[] = \Theme\Unemanettealamain\Utils::get()->getCriticalCss('tag-critical.css');
            } elseif (is_singular()) {
                $this->inlineStyles[] = \Theme\Unemanettealamain\Utils::get()->getCriticalCss('article-critical.css');
            }

            $cssUrl = \Theme\Unemanettealamain\Utils::get()->getRevisionAsset('style.css');
            if (!empty($cssUrl)) {
                wp_enqueue_style(
                    'bootstrap-style',
                    sprintf('%s/%s', get_template_directory_uri(), $cssUrl),
                    [],
                    null
                );
            }
        }
    }

    /**
     * Init css and js
     */
    public function initScripts()
    {
        if (!is_admin()) {
            $jsBootstrapUrl = \Theme\Unemanettealamain\Utils::get()->getRevisionAsset('bootstrap.js');
            if (!empty($jsBootstrapUrl)) {
                wp_enqueue_script(
                    'bootstrap-script',
                    sprintf('%s/%s', get_template_directory_uri(), $jsBootstrapUrl),
                    [],
                    null,
                    true
                );
            }

            $jsLazyUrl = \Theme\Unemanettealamain\Utils::get()->getRevisionAsset('lazysizes.js');
            if (!empty($jsLazyUrl)) {
                wp_enqueue_script(
                    'lazysizes-script',
                    sprintf('%s/%s', get_template_directory_uri(), $jsLazyUrl),
                    [],
                    null,
                    true
                );
            }

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
     * Init ACF plugin
     */
    public function initAcf()
    {
        // add Google API key
        acf_update_setting('google_api_key', 'AIzaSyAGFOaWMJhP1fJArEjmn50bR9_ubFtlEJI');
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

        $content = apply_filters('the_content', $post->post_content, true);

        // count words from raw content
        $wordCount = str_word_count($content);

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
     * Return post content
     *
     * @param string $content
     * @param bool $raw
     * @return string
     */
    public function the_content($content, $raw = false)
    {
        if (!$raw && !is_single()) {
            return $content;
        }

        $entity = new Entity();

        $content = $entity->getContent($content);

        if ($raw && !empty($content)) {
            // get raw content without html tags
            return strip_tags($content);
        }

        return $content;
    }

    /**
     * Add container to embed object
     *
     * @param string $html
     * @return string
     */
    public function addEmbedContainer($html)
    {
        if (is_admin() || mb_strpos($html, 'class="embed-container') !== false) {
            return $html;
        }

        $ratio = Utils::get()->getEmbedRatio($html);

        if (empty($ratio)) {
            return sprintf(
                '<div class="embed-container">%s</div>',
                $html
            );
        }

        return sprintf(
            '<div class="embed-container embed-responsive" style="padding-top: %s%%">%s</div>',
            round($ratio * 100, 3),
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
     * Add script for using service worker
     */
    public function initServiceWorker()
    {
        if (is_admin()) {
            return;
        }

        $wsUrl = \Theme\Unemanettealamain\Utils::get()->getRevisionAsset('service-worker.js');

        if (empty($wsUrl)) {
            return;
        }
        ?>
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker
                .register('/wp-content/themes/unemanettealamain/<?php echo $wsUrl; ?>', {scope: '/'});
            }
        </script>
        <?php
    }

    public function addInlinedStyles()
    {
        foreach (array_filter($this->inlineStyles) as $css) {
            echo sprintf('<style>%s</style>', $css);
        }
    }

    public function transformLinkStylesheet($tag)
    {
        if (preg_match("#^<link rel='stylesheet'.* media='(screen|all)'#", $tag, $matches)) {
            return str_replace(
                "media='$matches[1]'",
                "media='print' onload=\"this.media='$matches[1]'; this.onload=null;\"",
                $tag
            );
        }

        return $tag;
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

    /**
     * Add async and/or defer attributes to a script tag
     *
     * @param string $tag
     * @param string $handle
     * @return string
     */
    public function addAsyncAttribute($tag, $handle)
    {
        if (in_array($handle, self::SCRIPTS_ASYNC)) {
            return str_replace(' src=', ' async defer src=', $tag);
        } elseif (in_array($handle, self::SCRIPTS_DEFER)) {
            return str_replace(' src=', ' defer src=', $tag);
        }

        return $tag;
    }

    /**
     * Remove jquery migrate script from loaded scripts
     *
     * @param \stdClass $scripts
     * @return \stdClass
     */
    public function removeJqueryMigrate($scripts)
    {
        if (!is_admin() && !empty($scripts->registered['jquery']->deps)) {
            $scripts->registered['jquery']->deps = array_values(
                array_filter(
                    $scripts->registered['jquery']->deps,
                    function ($v) {
                        return $v !== 'jquery-migrate';
                    }
                )
            );
        }

        return $scripts;
    }

    /**
     * Remove json LD inserted by Yoast plugin
     * We already insert our json LD in the footer
     *
     * @return array
     */
    public function removeYoastJson()
    {
        return [];
    }

    /**
     * Transform image attributes for lazyload
     * @param array $attr
     * @return array
     */
    public function addAttachmentImageLazyload(array $attr)
    {
        if (is_feed() || is_preview() || is_admin()) {
            return $attr;
        }

        $attr['data-src'] = $attr['src'] ?? '';
        $attr['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $attr['class'] = 'lazyload '. $attr['class'];

        if (isset($attr['srcset'])) {
            $attr['data-srcset'] = $attr['srcset'];
            unset($attr['srcset']);
        }

        if (isset($attr['sizes'])) {
            $attr['data-sizes'] = $attr['sizes'];
            unset($attr['sizes']);
        }

        return $attr;
    }

    /**
     * Set lazyload for img tags in provided content
     * @param string $content
     * @param bool $raw
     * @return string
     */
    public function addImgLazyload($content, $raw = false)
    {
        if ($raw || is_feed() || is_preview() || is_admin()) {
            return $content;
        }

        return $this->addLazyloadWithTag(
            $content,
            'img',
            [
                'src' => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==',
                'srcset' => '',
                'sizes' => '',
            ]
        );
    }

    /**
     * Set lazyload in provided content
     * @param string $content
     * @param bool $raw
     * @return string
     */
    public function addMiscLazyload($content, $raw = false)
    {
        if ($raw || is_feed() || is_preview() || is_admin()) {
            return $content;
        }

        $content = $this->addLazyloadWithTag(
            $content,
            'iframe',
            ['src' => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==']
        );
        $content = $this->addLazyloadWithTag(
            $content,
            'video',
            ['src' => '', 'poster' => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==']
        );
        return $this->addLazyloadWithTag(
            $content,
            'embed',
            ['src' => '']
        );
    }

    /**
     * Set lazyload for all tags with provided replacements in content
     * @param string $content
     * @param string $tag
     * @param array $replacements
     * @return string
     */
    private function addLazyloadWithTag($content, $tag, array $replacements)
    {
        $matches = [];
        preg_match_all(
            sprintf('#<%s[\s\r\n]+.*?>#is', $tag),
            $content,
            $matches
        );

        if (empty($matches)) {
            return $content;
        }

        foreach ($matches[0] as $eltHtml) {
            // if lazyload is already applied, do not change html
            if (mb_strpos($eltHtml, 'lazyload') !== false) {
                continue;
            }

            // build search regex
            $search = [];
            $replace = [];
            foreach ($replacements as $att => $value) {
                $search[] = sprintf('#<%s(.*?)%s=#is', $tag, $att);
                $replace[] = sprintf('<%s$1%s data-%s=', $tag, !empty($value) ? sprintf('%s="%s"', $att, $value) : '', $att);
            }

            // replace attributes
            $replaceHTML = preg_replace($search, $replace, $eltHtml);

            if (preg_match('#class=["\']#i', $replaceHTML)) {
                $replaceHTML = preg_replace(
                    '#class=(["\'])(.*?)["\']#is',
                    'class=$1lazyload $2$1',
                    $replaceHTML
                );
            } else {
                $replaceHTML = preg_replace(
                    sprintf('#<%s#is', $tag),
                    sprintf('<%s class="lazyload"', $tag),
                    $replaceHTML
                );
            }

            $content = str_replace($eltHtml, $replaceHTML, $content);
        }

        return $content;
    }
}

BootstrapTheme::get()
    ->init();
