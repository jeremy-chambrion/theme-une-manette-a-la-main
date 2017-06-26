<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'CreativeWork.php';

class TVSeries extends CreativeWork
{
    /**
     * Get configuration values
     *
     * @return array
     */
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'actor' => ['type' => 'Repeater', 'property' => 'entity-value-actors', 'values' => [
                    '@type' => 'Person',
                    'name' => ['property' => 'entity-actor-name'],
                    'sameAs' => ['property' => 'entity-actor-url']
                ]],
                'director' => ['type' => 'Repeater', 'property' => 'entity-value-directors', 'values' => [
                    '@type' => 'Person',
                    'name' => ['property' => 'entity-director-name'],
                    'sameAs' => ['property' => 'entity-director-url']
                ]],
                'musicBy' => ['type' => 'Repeater', 'property' => 'entity-value-musicby', 'values' => [
                    '@type' => ['property' => 'entity-musicby-type'],
                    'name' => ['property' => 'entity-musicby-name'],
                    'sameAs' => ['property' => 'entity-musicby-url']
                ]],
                'productionCompany' => ['type' => 'Repeater', 'property' => 'entity-value-productioncompanies', 'values' => [
                    '@type' => 'Organization',
                    'name' => ['property' => 'entity-productioncompany-name'],
                    'sameAs' => ['property' => 'entity-productioncompany-url']
                ]],
                'trailer' => ['type' => 'VideoObject', 'property' => 'entity-value-trailer'],
                'countryOfOrigin' => ['type' => 'Object', 'values' => [
                    '@type' => 'Country',
                    'name' => ['property' => 'entity-value-origincountry']
                ]],
                'numberOfSeasons' => ['property' => 'entity-value-numberseasons'],
                'numberOfEpisodes' => ['property' => 'entity-value-numberepisodes']
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return [];
        }

        return array_merge(
            parent::getCardItems(),
            [
                $this->addCardItem(
                    'Acteur(s)',
                    $this->getRepeaterText('entity-value-actors', 'entity-actor-name', 'entity-actor-url'),
                    'comments'
                ),
                $this->addCardItem(
                    'Réalisateur(s)',
                    $this->getRepeaterText('entity-value-directors', 'entity-director-name', 'entity-director-url'),
                    'bullhorn'
                ),
                $this->addCardItem(
                    'Compositeur(s)',
                    $this->getRepeaterText('entity-value-musicby', 'entity-musicby-name', 'entity-musicby-url'),
                    'music'
                ),
                $this->addCardItem(
                    'Société de production',
                    $this->getRepeaterText('entity-value-productioncompanies', 'entity-productioncompany-name', 'entity-productioncompany-url'),
                    'building-o'
                ),
                $this->addCardItem(
                    'Pays de production',
                    get_field('entity-value-origincountry', $this->post),
                    'globe'
                )
            ]
        );
    }
}
