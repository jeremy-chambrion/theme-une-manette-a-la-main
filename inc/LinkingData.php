<?php

namespace Theme\Unemanettealamain;

class LinkingData
{
    /**
     * @var LinkingData
     */
    private static $singleton;

    private $data;

    private $dataOrganization;

    private $dataAuthors;

    private $rating = [
        'awesome' => 5,
        'good' => 4,
        'average' => 3,
        'bad' => 2,
        'shit' => 1
    ];

    public function __construct()
    {
        global $wp;

        $this->data = [
            '@context' => 'http://schema.org',
            '@type' => 'WebPage',
            'name' => wp_title('&raquo;', false),
            'description' => strip_tags(get_the_archive_description()),
            'url' => home_url($wp->request),
            'inLanguage' => [
                '@type' => 'Language',
                'alternateName' => get_bloginfo('language')
            ],
            'isAccessibleForFree' => true,
            'license' => 'https://creativecommons.org/licenses/by-sa/4.0/deed.fr'
        ];

        $this->data['@id'] = $this->data['url'];

        if (is_front_page()) {
            $this->addData($this->getDataBlog());
        } else {
            $this->data['breadcrumb'] = $this->getdataBreadcrumb();
        }

        if (is_home()) {
            $this->data['dateModified'] = date('c', strtotime(get_lastpostmodified()));
        } elseif (is_search()) {
            $this->data['@type'] = 'SearchResultsPage';
        }
    }

    /**
     * Return singleton
     *
     * @return LinkingData
     */
    public static function get()
    {
        if (is_null(self::$singleton)) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    /**
     * Get html for JsonLD
     *
     * @return string
     */
    public function getJsonLdHtml()
    {
        $json = json_encode(array_filter($this->data));

        if (json_last_error() !== JSON_ERROR_NONE) {
            return '';
        }

        return sprintf(
            '<script type="application/ld+json">%s</script>',
            $json
        );
    }

    /**
     * Add some data
     *
     * @param array $data
     * @return $this
     */
    public function addData(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Add provided structured data of a post
     *
     * @param \WP_Post|null $post
     * @return $this
     */
    public function addPost(\WP_Post $post = null)
    {
        $data = $this->getDataPost($post, is_single());

        if (is_single()) {
            $this->data['mainEntity'] = $data;

            return $this;
        }

        if (!isset($this->data['mainEntity'])) {
            $this->data['mainEntity'] = [
                '@type' => 'ItemList',
                'itemListElement' => []
            ];
        }

        $this->data['mainEntity']['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => count($this->data['mainEntity']['itemListElement']) + 1,
            'item' => $data
        ];

        return $this;
    }

    /**
     * Get structured data for blog organization
     *
     * @return array
     */
    private function getDataOrganization()
    {
        if (!isset($this->dataOrganization)) {
            $this->dataOrganization = [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url(),
                'sameAs' => []
            ];

            // get social links
            $links = Utils::get()
                ->getSocialLinks();

            foreach ($links as $link) {
                $this->dataOrganization['sameAs'][] = $link['url'];
            }

            // get custom logo
            $customLogoId = get_theme_mod('custom_logo');

            if (!empty($customLogoId)) {
                $customLogo = wp_get_attachment_image_src($customLogoId, 'full');

                if (!empty($customLogo)) {
                    $this->dataOrganization['logo'] = [
                        '@type' => 'ImageObject',
                        'url' => $customLogo[0],
                        'width' => $customLogo[1],
                        'height' => $customLogo[2]
                    ];
                }
            }

            $this->dataOrganization = array_filter($this->dataOrganization);
        }

        return $this->dataOrganization;
    }

    /**
     * Get structured data for blog
     *
     * @param bool $complete
     * @return array
     */
    private function getDataBlog($complete = false)
    {
        $organization = $this->getDataOrganization();

        $data = [
            '@type' => 'Blog',
            'name' => $organization['name'],
            'url' => $organization['url']
        ];

        if (!$complete) {
            return $data;
        }

        $data['@id'] = $data['url'];
        $data['description'] = get_bloginfo('description');
        $data['dateModified'] = date('c', strtotime(get_lastpostmodified()));
        $data['potentialAction'] = [
            '@type' => 'SearchAction',
            'target' => sprintf('%s?s={search_term_string}', $data['url']),
            'query-input' => 'required name=search_term_string'
        ];

        if (!empty($organization['logo'])) {
            $data['image'] = $organization['logo'];
        }

        return $data;
    }

    /**
     * Get structured data of a post
     * If post is not given, using post in the loop
     *
     * @param null|\WP_Post $post
     * @param bool $complete
     * @return array
     */
    private function getDataPost($post = null, $complete = true)
    {
        if (empty($post)) {
            $post = get_post();
        }

        $data = [
            '@type' => 'Article',
            'headline' => get_the_title($post),
            'mainEntityOfPage' => get_permalink($post),
            'datePublished' => get_the_date('c', $post),
            'dateModified' => get_the_modified_date('c', $post),
            'author' => $this->getDataAuthor($post->post_author ?? null),
            'publisher' => $this->getDataOrganization()
        ];

        // add post image
        if (has_post_thumbnail($post)) {
            // add image of post to structured data
            $postThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'full');
            $data['image'] = [
                '@type' => 'ImageObject',
                'url' => $postThumbnail[0],
                'width' => $postThumbnail[1],
                'height' => $postThumbnail[2]
            ];

            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'medium');
            $data['image']['thumbnail'] = [
                '@type' => 'ImageObject',
                'url' => $thumbnail[0],
                'width' => $thumbnail[1],
                'height' => $thumbnail[2]
            ];
        }

        if ($complete) {
            $data = array_merge($data, $this->getDataPostComplete($post));
        }

        return array_filter($data);
    }

    /**
     * Get structured data for a complete post
     *
     * @param \WP_Post $post
     * @return array
     */
    private function getDataPostComplete(\WP_Post $post)
    {
        $data = [
            'description' => strip_tags(get_the_excerpt($post)),
            'wordCount' => str_word_count(strip_tags($post->post_content)),
            'commentCount' => get_comments_number($post),
            'comment' => $this->getDataComments($post),
            'keywords' => [],
            'articleSection' => []
        ];

        // add tags
        $tags = wp_get_post_tags($post->ID);
        foreach ($tags as $tag) {
            $data['keywords'][] = $tag->name;
        }

        // add categories
        $postCategories = get_the_category();
        foreach ($postCategories as $category) {
            $data['articleSection'][] = $category->name;
        }

        // reading time
        $readingTime = BootstrapTheme::get()
            ->getPostReadingTime($post);
        if (!empty($readingTime)) {
            $data['timeRequired'] = sprintf('PT%sM', $readingTime);
        }

        // getting entity
        $entity = new Entity($post);
        $data['mainEntity'] = $entity->getLinkingData();

        // getting review
        $review = $this->getDataReview($post);

        if (empty($review)) {
            return $data;
        }

        if (empty($data['mainEntity'])) {
            $data['mainEntity'] = $review;
        } else {
            // fix entity data
            if ($data['mainEntity']['@type'] === 'Recipe' && empty($data['mainEntity']['author'])) {
                $data['mainEntity']['author'] = $this->getDataAuthor($post->post_author);
            }

            $data['mainEntity']['review'] = $review;
        }

        return $data;
    }

    /**
     * Get structured data for author with provided id
     *
     * @param int $authorId
     * @return array
     */
    private function getDataAuthor($authorId)
    {
        if (empty($authorId)) {
            return [];
        }

        if (!isset($this->dataAuthors[$authorId])) {
            $authorName = get_the_author_meta('display_name', $authorId);

            $this->dataAuthors[$authorId] = [
                '@type' => 'Person',
                'name' => $authorName,
                'url' => get_author_posts_url($authorId, $authorName),
                'image' => [
                    '@type' => 'ImageObject',
                    'url' => get_avatar_url(get_the_author_meta('email', $authorId))
                ]
            ];
        }

        return $this->dataAuthors[$authorId];
    }

    /**
     * Get structured data for breacrumb
     *
     * @return array|null
     */
    private function getDataBreadcrumb()
    {
        $breadcrumbItems = Utils::get()
            ->getBreadcrumbItems();

        if (empty($breadcrumbItems)) {
            return [];
        }

        $homeUrl = home_url();

        $data = [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@type' => 'Blog',
                        '@id' => $homeUrl,
                        'url' => $homeUrl,
                        'name' => 'Accueil'
                    ]
                ]
            ]
        ];

        foreach ($breadcrumbItems as $key => $item) {
            $category = get_category_by_slug($item);
            $link = get_category_link($category);
            $data['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $key + 2,
                'item' => [
                    '@type' => 'WebPage',
                    '@id' => $link,
                    'url' => $link,
                    'name' => $category->name
                ]
            ];
        }

        return $data;
    }

    /**
     * Get structured data for review of provided post
     * (if available)
     *
     * @param \WP_Post $post
     * @return array
     */
    private function getDataReview(\WP_Post $post)
    {
        if (!class_exists('acf')) {
            return [];
        }

        if (!get_field('post-opinion-activate', $post)) {
            return [];
        }

        $rating = get_field('post-opinion-feeling');

        $data = [
            '@type' => 'Review',
            'reviewBody' => get_field('post-opinion-summary', $post),
            'author' => $this->getDataAuthor($post->post_author ?? null),
            'datePublished' => get_the_date('c', $post),
            'publisher' => $this->getDataOrganization()
        ];

        if (!empty($rating) && isset($this->rating[$rating])) {
            $data['reviewRating'] = [
                '@type' => 'Rating',
                'ratingValue' => $this->rating[$rating],
                'bestRating' => max($this->rating),
                'worstRating' => min($this->rating)
            ];
        }

        return array_filter($data);
    }

    private function getDataComments(\WP_Post $post)
    {
        $comments = get_comments([
            'post_id' => $post->ID,
            'status' => 'approve',
            'type' => 'comment'
        ]);

        if (empty($comments)) {
            return [];
        }

        $data = [];
        foreach ($comments as $comment) {
            $data[] = array_filter([
                '@type' => 'Comment',
                'author' => array_filter([
                    '@type' => 'Person',
                    'name' => $comment->comment_author,
                    'url' => $comment->comment_author_url
                ]),
                'datePublished' => date('c', strtotime($comment->comment_date)),
                'text' => strip_tags($comment->comment_content)
            ]);
        }

        return $data;
    }
}
