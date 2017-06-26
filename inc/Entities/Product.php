<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'Thing.php';

class Product extends Thing
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
                'brand' => ['type' => 'Repeater', 'property' => 'entity-value-brand', 'values' => [
                    '@type' => 'Brand',
                    'name' => ['property' => 'entity-brand-name'],
                    'url' => ['proeprty' => 'entity-brand-url']
                ]],
                'manufacturer' => ['type' => 'Repeater', 'property' => 'entity-value-manufacturer', 'values' => [
                    '@type' => 'Organization',
                    'name' => ['property' => 'entity-manufacturer-name'],
                    'url' => ['property' => 'entity-manufacturer-url']
                ]]
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
                    'Marque',
                    $this->getRepeaterText('entity-value-brand', 'entity-brand-name', 'entity-brand-url'),
                    'product-hunt'
                ),
                $this->addCardItem(
                    'Fabricant',
                    $this->getRepeaterText('entity-value-manufacturer', 'entity-manufacturer-name', 'entity-manufacturer-url'),
                    'building-o'
                )
            ],
            parent::getCardItems()
        );
    }
}
