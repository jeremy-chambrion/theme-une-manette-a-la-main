<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'Place.php';

class LocalBusiness extends Place
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'priceRange' => ['property' => 'entity-value-pricerange']
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return[];
        }

        return array_merge(
            parent::getCardItems(),
            [
                $this->addCardItem(
                    'Prix',
                    get_field('entity-value-pricerange', $this->post),
                    'money'
                )
            ]
        );
    }
}
