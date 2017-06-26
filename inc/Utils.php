<?php

namespace Theme\Unemanettealamain;

class Utils
{
    /**
     * @var Utils
     */
    private static $singleton;

    /**
     * @var array
     */
    private $socialLinks = [
        'facebook' => ['label' => 'Facebook', 'url' => 'https://www.facebook.com/manettealamain'],
        'twitter' => ['label' => 'Twitter', 'url' => 'https://twitter.com/manettealamain'],
        'instagram' => ['label' => 'Instagram', 'url' => 'https://www.instagram.com/manettealamain/']
    ];

    /**
     * Return singleton
     *
     * @return Utils
     */
    public static function get()
    {
        if (is_null(self::$singleton)) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    /**
     * Get social links
     *
     * @return array
     */
    public function getSocialLinks()
    {
        return $this->socialLinks;
    }

    /**
     * Get the primary category of current post
     *
     * @return bool|int|null
     */
    public function getPrimaryCategory()
    {
        // if YOAST plugin installed and activated, get main category
        // otherwise return deepest category
        if (function_exists('yoast_get_primary_term_id')) {
            return yoast_get_primary_term_id();
        }

        return array_pop(get_the_category());
    }

    /**
     * Get breadcrumb items
     *
     * @param bool $slug
     * @return array
     */
    public function getBreadcrumbItems($slug = true)
    {
        if (is_category()) {
            global $cat;

            if (empty($cat)) {
                return [];
            }

            return array_filter(
                explode(
                    '|',
                    get_category_parents($cat, false, '|', $slug)
                )
            );
        } elseif (is_single()) {
            $primaryCategoryId = $this->getPrimaryCategory();

            if (!empty($primaryCategoryId)) {
                return array_filter(
                    explode(
                        '|',
                        get_category_parents($primaryCategoryId, true, '|', $slug)
                    )
                );
            }
        }

        return [];
    }

    /**
     * Print list of posts in a generic manner
     *
     * @param \WP_Query|null $query
     */
    public function printGridList(\WP_Query $query = null)
    {
        if (empty($query)) {
            // get current query
            global $wp_query;

            $query = $wp_query;
        }

        if ($query->have_posts()) {
            echo '<div class="row">';
            $cpt = 0;

            /* Start the Loop */
            while ($query->have_posts()) {
                echo '<div class="col-xs-12 col-md-6">';
                $query->the_post();
                get_template_part('template-parts/excerpt/article', get_post_format());
                echo '</div>';

                // add post to structured data
                LinkingData::get()
                    ->addPost();

                if ($cpt%2 !== 0) {
                    echo '</div><div class="row">';
                }
                $cpt++;
            }

            echo '</div>';
        } else {
            get_template_part('template-parts/common/none');
        }
    }

    /**
     * Print list of posts specifically for the front page.
     * Posts are displayed up to 3 posts on a line.
     *
     * @param \WP_Query $query
     * @param string $title
     * @param bool $withFeatured
     * @param string|null $classSection
     * @param string|null $icon
     * @param string|null $link
     */
    public function printFrontGridList(\WP_Query $query, $title, $withFeatured = false, $classSection = null, $icon = null, $link = null)
    {
        if (!$query->have_posts()) {
            return;
        }

        if ($classSection) {
            printf(
                '<section class="%s">',
                $classSection
            );
        }

        // display header if $title is not false
        if ($title !== false) {
            printf(
                '<div class="page-header">%s<h2 class="page-title">%s%s%s</h2>%s</div>',
                $link ? sprintf('<a href="%s">', esc_url($link)) : '',
                $icon ? sprintf('<i class="fa %s" aria-hidden="true"></i>', $icon) : '',
                $title,
                $link ? '<i class="fa fa-chevron-right" aria-hidden="true"></i>' : '',
                $link ? '</a>' : ''
            );
        }

        // display grid of posts
        if ($withFeatured || $query->post_count === 1) {
            $classRow = 'grid-list-full';
        } elseif ($query->post_count === 2) {
            $classRow = 'grid-list-mid';
        } else {
            $classRow = 'grid-list-third';
        }
        printf(
            '<div class="row %s">',
            $classRow
        );

        $cpt = 0;
        while ($query->have_posts()) {
            echo '<div>';
            $query->the_post();
            get_template_part('template-parts/excerpt/article', get_post_format());
            echo '</div>';

            // add post to structured data
            LinkingData::get()
                ->addPost();

            // if exactly 2 posts and one featured, do not display the second one
            if ($withFeatured && $query->post_count === 2) {
                break;
            }

            // if first ost is featured, then display the next ones on a new row
            if ($withFeatured && $cpt === 0 && $query->post_count > 1) {
                printf(
                    '</div><div class="row %s">',
                    $query->post_count === 3 ? 'grid-list-mid' : 'grid-list-third'
                );
            }

            $cpt++;
        }

        echo '</div>';

        if ($classSection) {
            echo '</section>';
        }
    }

    /**
     * Get query for latest posts on front page
     *
     * @param int $maxSticky
     * @param int $maxPosts
     * @return \WP_Query
     */
    public function getFrontLatestPosts($maxSticky = 1, $maxPosts = 4)
    {
        // first sticky posts id
        $stickyPostsId = get_option('sticky_posts');

        if (!empty($stickyPostsId) && !empty($maxSticky)) {
            $stickyPostsIdKept = array_slice($stickyPostsId, 0, $maxSticky);

            // then get sticky posts
            $stickyQuery = new \WP_Query(
                [
                    'post_type' => 'post',
                    'post__in' => $stickyPostsIdKept,
                    'ignore_sticky_posts' => true
                ]
            );
        } else {
            $stickyPostsIdKept = [];
        }

        // then get latest posts
        $latestPosts = new \WP_Query(
            [
                'post_type' => 'post',
                'ignore_sticky_posts' => true,
                'post__not_in' => $stickyPostsIdKept,
                'posts_per_page' => $maxPosts - count($stickyPostsIdKept)
            ]
        );

        // finally merge the queries
        if (!empty($stickyQuery)) {
            $combinedQuery = new \WP_Query();
            $combinedQuery->posts = array_merge($stickyQuery->posts, $latestPosts->posts);
            $combinedQuery->post_count = $stickyQuery->post_count + $latestPosts->post_count;

            return $combinedQuery;
        }

        return $latestPosts;
    }

    /**
     * Get data for inline thumbnail of the providing image data
     *
     * @param array $imageData
     * @return string
     */
    public function getThumbnailInlineData(array $imageData)
    {
        if (empty($imageData['sizes']['umalm-xsmall']) || empty($imageData['mime_type'])) {
            return '';
        }

        $urlPath = parse_url($imageData['sizes']['umalm-xsmall'], PHP_URL_PATH);
        $homePath = get_home_path();

        if (empty($urlPath) || empty($homePath)) {
            return '';
        }

        $thumbnailPath = realpath(
            sprintf(
                '%s/%s',
                rtrim($homePath, '/'),
                ltrim($urlPath, '/')
            )
        );

        if (empty($thumbnailPath) || !file_exists($thumbnailPath)) {
            return '';
        }

        $thumbnailContent = file_get_contents($thumbnailPath);

        if ($thumbnailContent === false || strlen($thumbnailContent) > 1000) {
            return '';
        }

        return sprintf(
            'data:%s;base64,%s',
            $imageData['mime_type'],
            base64_encode($thumbnailContent)
        );
    }
}
