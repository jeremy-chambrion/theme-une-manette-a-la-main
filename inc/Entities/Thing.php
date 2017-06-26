<?php

namespace Theme\Unemanettealamain\Entities;

class Thing
{
    /**
     * @var \WP_Post
     */
    protected $post;

    public function __construct(\WP_Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get content using default template
     *
     * @param string $content
     * @return string
     */
    public function getContent($content)
    {
        if (!class_exists('acf')) {
            return $content;
        }

        $items = array_filter($this->getCardItems());
        if (empty($items)) {
            return $content;
        }

        $image = get_field('entity-value-image');
        if (!empty($image['ID'])) {
            return sprintf(
                '%s<div class="card-container card-cover">
                    <div class="row">
                        <div class="card-image hidden-xs col-sm-3">%s</div>
                        <div class="card-list col-xs-12 col-sm-9">
                            <h3 class="card-title">%s</h3>
                            <dl class="dl-horizontal">%s</dl>
                        </div>
                    </div>
                </div>',
                $content,
                wp_get_attachment_image($image['ID'], 'medium_large'),
                get_field('entity-value-name', $this->post) ?? "Plus d'informations",
                implode('', $items)
            );
        }

        return sprintf(
            '%s<div class="card-container">
                <div class="card-list">
                    <h3 class="card-title">%s</h3>
                    <dl class="dl-horizontal">%s</dl>
                </div>
            </div>',
            $content,
            get_field('entity-value-name', $this->post) ?? "Plus d'informations",
            implode('', $items)
        );
    }

    /**
     * Get configuration values
     *
     * @return array
     */
    public function getValues()
    {
        return [
            'name' => ['property' => 'entity-value-name'],
            'description' => ['property' => 'entity-value-description'],
            'url' => ['property' => 'entity-value-url'],
            'sameAs' => ['property' => 'entity-value-sameas'],
            'image' => ['type' => 'ImageObject', 'property' => 'entity-value-image']
        ];
    }

    /**
     * Get card items
     *
     * @return array<string>
     */
    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return [];
        }

        $items = [];

        $url = get_field('entity-value-url', $this->post);
        if (!empty($url)) {
            $items[] = $this->addCardItem(
                'Site internet',
                sprintf(
                    '<a href="%s">%s</a>',
                    $url,
                    $url
                ),
                'external-link',
                'card-link'
            );
        }

        return $items;
    }

    /**
     * Add an item in the entity card
     * for displaying in the content
     *
     * @param string $title
     * @param string|null $text
     * @param string|null $icon
     * @return string
     */
    protected function addCardItem($title, $text, $icon = null, $textClass = null)
    {
        if (empty($text)) {
            return '';
        }

        if (!empty($icon)) {
            $title = sprintf(
                '<i class="fa fa-%s" aria-hidden="true"></i>%s',
                $icon,
                $title
            );
        }

        return sprintf(
            '<dt class="card-item-title">%s</dt><dd class="%s">%s</dd>',
            $title,
            $textClass ?? '',
            $text
        );
    }

    /**
     * Get text from a list of items with or without link
     *
     * @param string $property
     * @param string $textProperty
     * @param string|null $linkProperty
     * @param string $separator
     * @return string
     */
    protected function getRepeaterText($property, $textProperty, $linkProperty = null, $separator = ' — ')
    {
        $items = [];

        while (have_rows($property, $this->post)) {
            the_row();
            $text = get_sub_field($textProperty);

            if (empty($text)) {
                continue;
            }

            $link = !empty($linkProperty) ? get_sub_field($linkProperty) : null;

            if (!empty($link)) {
                $items[] = sprintf(
                    '<a href="%s" rel="nofollow">%s</a>',
                    $link,
                    $text
                );
            } else {
                $items[] = $text;
            }
        }

        return implode($separator, array_filter($items));
    }
}
