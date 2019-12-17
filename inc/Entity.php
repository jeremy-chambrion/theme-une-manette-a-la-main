<?php

namespace Theme\Unemanettealamain;

class Entity
{
    /**
     * @var null|Entities\Thing
     */
    private $entity;

    /**
     * @var \WP_Post|null
     */
    private $post;

    /**
     * @var array
     */
    private $alias = [
        'WebSite' => 'CreativeWork',
        'TouristAttraction' => 'Place',
        'CivicStructure' => 'Place',
        'Aquarium' => 'Place',
        'Museum' => 'Place',
        'Park' => 'Place',
        'MusicVenue' => 'Place',
        'PerformingArtsTheater' => 'Place',
        'StadiumOrArena' => 'Place',
        'Zoo' => 'Place',
        'BarOrPub' => 'FoodEstablishment',
        'FastFoodRestaurant' => 'FoodEstablishment',
        'Restaurant' => 'FoodEstablishment',
        'Library' => 'LocalBusiness',
        'ArtGallery' => 'LocalBusiness',
        'Store' => 'LocalBusiness',
        'AmusementPark' => 'LocalBusiness',
        'MovieTheater' => 'LocalBusiness'
    ];

    /**
     * @var array
     */
    private static $singletons = [];

    /**
     * Set post object
     *
     * @param \WP_Post|null $post
     */
    public function __construct(\WP_Post $post = null)
    {
        if (!class_exists('acf')) {
            return;
        }

        $this->entity = $this->getEntitySingleton($post);
    }

    /**
     * Get content
     *
     * @param string $content
     * @return string
     */
    public function getContent($content)
    {
        if (empty($this->entity)) {
            return $content;
        }

        return $this->entity->getContent($content);
    }

    /**
     * Get linking data
     *
     * @return array
     */
    public function getLinkingData()
    {
        if (!class_exists('acf') || empty($this->entity)) {
            return [];
        }

        $entityClassParts = explode('\\', get_class($this->entity));

        return array_merge(
            ['@type' => array_pop($entityClassParts)],
            $this->getDataEntityValues($this->entity->getValues())
        );
    }

    /**
     * Get linking data for provided values
     *
     * @param array $values
     * @param bool $isSub
     * @return array
     */
    private function getDataEntityValues(array $values, $isSub = false)
    {
        $data = [];

        foreach ($values as $key => $value) {
            if (!is_array($value)) {
                $data[$key] = $value;

                continue;
            }

            $valueType = $value['type'] ?? '';

            // special type without using property value
            if ($valueType === 'Object') {
                if (!empty($value['values'])) {
                    $data[$key] = $this->getDataEntityValues($value['values']);
                }

                continue;
            }

            if (empty($value['property'])) {
                continue;
            }

            // special type using repeater functionality
            if ($valueType === 'List') {
                if (!empty($value['subProperty'])) {
                    $data[$key] = [];
                    while (have_rows($value['property'], $this->post)) {
                        the_row();
                        $data[$key][] = get_sub_field($value['subProperty']);
                    }
                    $data[$key] = array_filter($data[$key]);
                }

                continue;
            } elseif ($valueType === 'Repeater') {
                if (!empty($value['values'])) {
                    $data[$key] = [];
                    while (have_rows($value['property'], $this->post)) {
                        the_row();
                        $data[$key][] = $this->getDataEntityValues($value['values'], true);
                    }
                }

                continue;
            }

            $field = $isSub ? get_sub_field($value['property']) : get_field($value['property'], $this->post);

            if (empty($field)) {
                continue;
            }

            switch ($valueType) {
            case 'ImageObject':
                $data[$key] = array_filter(
                    [
                        '@type' => 'ImageObject',
                        'url' => $field['url'],
                        'width' => $field['width'],
                        'height' => $field['height'],
                        'name' => $field['title'],
                        'description' => $field['description'],
                        'caption' => $field['caption'],
                        'thumbnail' => [
                            '@type' => 'ImageObject',
                            'url' => $field['sizes']['medium'],
                            'width' => $field['sizes']['medium-width'],
                            'height' => $field['sizes']['medium-height']
                        ]
                    ]
                );
                break;

            case 'GeoCoordinates':
                $data[$key] = array_filter(
                    [
                        '@type' => 'GeoCoordinates',
                        'latitude' => $field['lat'] ?? null,
                        'longitude' => $field['lng'] ?? null,
                        'address' => $field['address'] ?? null
                    ]
                );
                break;

            case 'Time':
                $data[$key] = date('H:i:s', strtotime($field));
                break;

            case 'Duration':
                $timestamp = strtotime($field);
                $hours = (int) date('G', $timestamp);
                $minutes = (int) date('i', $timestamp);
                $seconds = (int) date('s', $timestamp);

                if (!empty($hours) || !empty($minutes) || !empty($seconds)) {
                    $data[$key] = sprintf(
                        'PT%s%s%s',
                        !empty($hours) ? $hours . 'H' : '',
                        !empty($minutes) ? $minutes . 'M' : '',
                        !empty($seconds) ? $seconds . 'S' : ''
                    );
                }
                break;

            case 'VideoObject':
                $srcMatches = [];
                $titleMatches = [];
                if (preg_match('#src="([^"]+)"#', $field, $srcMatches)) {
                    $data[$key] = array_merge([
                        '@type' => 'VideoObject',
                        'url' => $srcMatches[1],
                    ], $value['values'] ?? []);

                    if (preg_match('#title="([^"]+)"#', $field, $titleMatches)) {
                        $data[$key]['description'] = $titleMatches[1];
                    }
                }
                break;

            case 'Gallery':
                $data[$key] = [];
                foreach ($field as $image) {
                    $data[$key][] = array_filter(
                        [
                            '@type' => 'ImageObject',
                            'url' => $image['url'],
                            'width' => $image['width'],
                            'height' => $image['height'],
                            'name' => $image['title'],
                            'description' => $image['description'],
                            'caption' => $image['caption'],
                            'thumbnail' => [
                                '@type' => 'ImageObject',
                                'url' => $image['sizes']['medium'],
                                'width' => $image['sizes']['medium-width'],
                                'height' => $image['sizes']['medium-height']
                            ]
                        ]
                    );
                }
                break;

            default:
                $data[$key] = $field;
            }

            // if value is an array with only one value,
            // set it as the value
            if (is_array($data[$key]) && count($data[$key]) === 1) {
                $data[$key] = $data[$key][0];
            }
        }

        return array_filter($data);
    }

    /**
     * Get entity object from singleton or new object
     *
     * @param \WP_Post|null $post
     * @return null|Entities\Thing
     */
    private function getEntitySingleton($post)
    {
        $this->post = get_post($post);

        if (empty($this->post)) {
            return null;
        }

        if (!empty($this->post->ID) && isset(static::$singletons[$this->post->ID])) {
            return static::$singletons[$this->post->ID];
        }

        $entity = $this->getNewEntity($this->post);

        if (!empty($this->post->ID)) {
            static::$singletons[$this->post->ID] = $entity;
        }

        return $entity;
    }

    /**
     * Get new entity object
     *
     * @return null|Entities\Thing
     */
    private function getNewEntity() {
        $entityType = get_field('entity-type', $this->post);

        if (empty($entityType)) {
            return null;
        }

        $filePath = sprintf(
            '%s/Entities/%s.php',
            dirname(__FILE__),
            $entityType
        );

        if (realpath($filePath)) {
            include_once $filePath;

            $entityClass = sprintf(
                '%s\Entities\%s',
                __NAMESPACE__,
                $entityType
            );

            if (class_exists($entityClass)) {
                return new $entityClass($this->post);
            }
        }

        if (!isset($this->alias[$entityType])) {
            return null;
        }

        $filePath = sprintf(
            '%s/Entities/%s.php',
            dirname(__FILE__),
            $this->alias[$entityType]
        );

        if (realpath($filePath)) {
            include_once $filePath;

            $entityClass = sprintf(
                '%s\Entities\%s',
                __NAMESPACE__,
                $this->alias[$entityType]
            );

            if (class_exists($entityClass)) {
                return new $entityClass($this->post);
            }
        }

        return null;
    }
}
