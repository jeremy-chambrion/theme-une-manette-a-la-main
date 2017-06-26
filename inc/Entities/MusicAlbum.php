<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'CreativeWork.php';

class MusicAlbum extends CreativeWork
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'byArtist' => ['type' => 'Repeater', 'property' => 'entity-value-artists', 'values' => [
                    '@type' => 'MusicGroup',
                    'name' => ['property' => 'entity-artist-name'],
                    'sameAs' => ['property' => 'entity-artist-url']
                ]],
                'albumProductionType' => ['type' => 'Object', 'values' => [
                    '@type' => 'MusicAlbumProductionType',
                    'name' => ['property' => 'entity-value-music-production']
                ]],
                'albumReleaseType' => ['type' => 'Object', 'values' => [
                    '@type' => 'MusicAlbumReleaseType',
                    'name' => ['property' => 'entity-value-music-release']
                ]],
                'numTracks' => ['property' => 'entity-value-music-tracks']
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return [];
        }

        return array_merge(
            [
                $this->addCardItem(
                    'Artiste',
                    $this->getRepeaterText('entity-value-artists', 'entity-artist-name', 'entity-artist-url'),
                    'microphone'
                )
            ],
            parent::getCardItems()
        );
    }
}
