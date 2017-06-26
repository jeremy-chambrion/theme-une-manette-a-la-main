<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'CreativeWork.php';

class Game extends CreativeWork
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'numberOfPlayers' => ['type' => 'Object', 'values' => [
                    '@type' => 'QuantitativeValue',
                    'minValue' => ['property' => 'entity-value-game-number-min'],
                    'maxValue' => ['property' => 'entity-value-game-number-max']
                ]]
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return [];
        }

        $minPlayers = get_field('entity-value-game-number-min', $this->post);
        $maxPlayers = get_field('entity-value-game-number-max', $this->post);

        $players = '';

        if (empty($minPlayers) && !empty($maxPlayers)) {
            $players = sprintf(
                "Jusqu'à %s joueur%s",
                $maxPlayers,
                $maxPlayers > 1 ? 's' : ''
            );
        } elseif (empty($maxPlayers) && !empty($minPlayers)) {
            $players = sprintf(
                'À partir de %s joueur%s',
                $minPlayers,
                $minPlayers > 1 ? 's' : ''
            );
        } elseif (!empty($minPlayers) && !empty($maxPlayers)) {
            if ($minPlayers === $maxPlayers) {
                $players = sprintf(
                    '%s joueur%s',
                    $minPlayers,
                    $minPlayers > 1 ? 's' : ''
                );
            } else {
                $players = sprintf(
                    'Entre %s et %s joueurs',
                    $minPlayers,
                    $maxPlayers
                );
            }
        }

        return array_merge(
            parent::getCardItems(),
            [
                $this->addCardItem(
                    'Nombre de joueurs',
                    $players,
                    'users'
                )
            ]
        );
    }
}
