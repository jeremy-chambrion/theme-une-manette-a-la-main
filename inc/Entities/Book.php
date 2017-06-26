<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'CreativeWork.php';

class Book extends CreativeWork
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'bookFormat' => ['property' => 'entity-value-book-format'],
                'numberOfPages' => ['property' => 'entity-value-book-numberpages'],
                'bookEdition' => ['property' => 'entity-value-book-edition'],
                'isbn' => ['property' => 'entity-value-book-isbn']
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
                'ISBN',
                get_field('entity-value-book-isbn', $this->post),
                'barcode'
            )
        ];

        return array_merge(
            parent::getCardItems(),
            $items
        );
    }
}
