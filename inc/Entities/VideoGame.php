<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'Game.php';

class VideoGame extends Game
{
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
                'trailer' => ['type' => 'VideoObject', 'property' => 'entity-value-trailer', 'values' => [
                    'name' => 'Trailer'
                ]],
                'playMode' => ['property' => 'entity-value-videogame-mode'],
                'gamePlatform' => ['property' => 'entity-value-videogame-platform']
            ]
        );
    }

    public function getContent($content)
    {
        if (class_exists('acf')) {
            $trailer = get_field('entity-value-trailer');

            if (!empty($trailer)) {
                $content = sprintf(
                    '%s<p class="video-container">%s</p>',
                    $content,
                    $trailer
                );
            }
        }

        return parent::getContent($content);
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
                )
            ]
        );
    }
}
