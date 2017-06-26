<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'Thing.php';

class CreativeWork extends Thing
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'author' => ['type' => 'Repeater', 'property' => 'entity-value-author', 'values' => [
                    '@type' => ['property' => 'entity-author-type'],
                    'name' => ['property' => 'entity-author-name'],
                    'sameAs' => ['property' => 'entity-author-url']
                ]],
                'publisher' => ['type' => 'Repeater', 'property' => 'entity-value-publisher', 'values' => [
                    '@type' => ['property' => 'entity-publisher-type'],
                    'name' => ['property' => 'entity-publisher-name'],
                    'sameAs' => ['property' => 'entity-publisher-url']
                ]],
                'producer' => ['type' => 'Repeater', 'property' => 'entity-value-producer', 'values' => [
                    '@type' => ['property' => 'entity-producer-type'],
                    'name' => ['property' => 'entity-producer-name'],
                    'sameAs' => ['property' => 'entity-producer-url']
                ]],
                'award' => ['type' => 'List', 'property' => 'entity-value-awards', 'subProperty' => 'entity-award-name'],
                'datePublished' => ['property' => 'entity-value-publication'],
                'typicalAgeRange' => ['property' => 'entity-value-agerange']
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return [];
        }

        $items = [
            $this->addCardItem(
                'Auteur(s)',
                $this->getRepeaterText('entity-value-author', 'entity-author-name', 'entity-author-url'),
                'pencil-square-o'
            ),
            $this->addCardItem(
                'Editeur(s)',
                $this->getRepeaterText('entity-value-publisher', 'entity-publisher-name', 'entity-publisher-url'),
                'users'
            ),
            $this->addCardItem(
                'Producteur(s)',
                $this->getRepeaterText('entity-value-producer', 'entity-producer-name', 'entity-producer-url'),
                'users'
            )
        ];

        $date = get_field('entity-value-publication');
        if (!empty($date)) {
            $originalLocale = setlocale(LC_TIME, 0);
            setlocale(LC_TIME, 'fr_FR.UTF-8');
            $items[] = $this->addCardItem(
                'Date de publication',
                strftime('%e %B %Y', strtotime($date)),
                'calendar-o'
            );
            setlocale(LC_TIME, $originalLocale);
        }

        return array_merge(
            $items,
            parent::getCardItems()
        );
    }
}
