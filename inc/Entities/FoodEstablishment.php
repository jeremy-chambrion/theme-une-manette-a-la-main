<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'LocalBusiness.php';

class FoodEstablishment extends LocalBusiness
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'servesCuisine' => ['property' => 'entity-value-food-cuisine'],
                'hasMenu' => ['property' => 'entity-value-food-menu'],
                'acceptsReservations' => ['property' => 'entity-value-food-reservations']
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return[];
        }

        $items = [];

        $menuUrl = get_field('entity-value-food-menu', $this->post);
        $reservationUrl = get_field('entity-value-food-reservations', $this->post);

        if (!empty($menuUrl)) {
            $items[] = $this->addCardItem(
                'Menu',
                sprintf(
                    '<a href="%s">%s</a>',
                    $menuUrl,
                    $menuUrl
                ),
                'book',
                'card-link'
            );
        }

        if (!empty($reservationUrl)) {
            $items[] = $this->addCardItem(
                'Réservations',
                sprintf(
                    '<a href="%s">%s</a>',
                    $reservationUrl,
                    $reservationUrl
                ),
                'address-book-o',
                'card-link'
            );
        }

        return array_merge(
            parent::getCardItems(),
            $items
        );
    }
}
