<?php

namespace Theme\Unemanettealamain\Entities;

use Theme\Unemanettealamain\LinkingData;

require_once 'CreativeWork.php';

class Recipe extends CreativeWork
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'recipeCuisine' => ['property' => 'entity-value-recipe-cuisine'],
                'recipeCategory' => ['property' => 'entity-value-recipe-category'],
                'cookingMethod' => ['property' => 'entity-value-recipe-cookmethod'],
                'recipeYield' => ['property' => 'entity-value-recipe-yield'],
                'recipeIngredient' => ['type' => 'List', 'property' => 'entity-value-recipe-ingredients', 'subProperty' => 'entity-ingredient-name'],
                'recipeInstructions' => ['type' => 'List', 'property' => 'entity-value-recipe-instructions', 'subProperty' => 'entity-instruction-text'],
                'prepTime' => ['type' => 'Duration', 'property' => 'entity-value-recipe-preptime'],
                'cookTime' => ['type' => 'Duration', 'property' => 'entity-value-recipe-cooktime'],
                'totalTime' => ['type' => 'Duration', 'property' => 'entity-value-recipe-totaltime']
            ]
        );
    }

    public function getContent($content)
    {
        if (!class_exists('acf')) {
            return $content;
        }

        $items = array_filter($this->getCardItems());
        if (!empty($items)) {
            $content = sprintf(
                '%s<div class="card-container">
                    <div class="card-list">
                        <h3 class="card-title">%s</h3>
                        <dl class="dl-horizontal">%s</dl>
                    </div>
                </div>',
                $content,
                'Détails de la recette',
                implode('', $items)
            );
        }

        $instructions = [];
        $rows = get_field('entity-value-recipe-instructions', $this->post);

        if (!empty($rows)) {
            $lastKey = count($rows) - 1;
            $lastRow = null;

            if (!empty($rows[$lastKey]['entity-instruction-gallery'])
                && count($rows[$lastKey]['entity-instruction-gallery']) === 1
                && !empty($rows[$lastKey]['entity-instruction-gallery'][0]['ID'])
            ) {
                $lastRow = array_pop($rows);
            }

            foreach ($rows as $key => $row) {
                $instructions[] = $this->getInstructionHtml($row);
            }

            if (!empty($lastRow['entity-instruction-text'])) {
                $instructions[] = sprintf(
                    '<li>%s</li>',
                    $lastRow['entity-instruction-text']
                );
            }
        }

        $instructions = array_filter($instructions);

        if (!empty($instructions)) {
            $content .= sprintf(
                '<ul>%s</ul>',
                implode('', $instructions)
            );
        }

        if (!empty($lastRow)) {
            $content .= wp_get_attachment_image($lastRow['entity-instruction-gallery'][0]['ID'], 'umalm-xlarge', false, ['class' => 'wp-image- aligncenter']);
        }

        return $content;
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return [];
        }

        $items = [
            $this->addCardItem(
                'Nombre de plats',
                get_field('entity-value-recipe-yield', $this->post),
                'users'
            )
        ];

        $prepTime = get_field('entity-value-recipe-preptime', $this->post);
        if (!empty($prepTime)) {
            $items[] = $this->addCardItem(
                'Temps de préparation',
                date('i', strtotime($prepTime)) . ' min.',
                'clock-o'
            );
        }

        $cookTime = get_field('entity-value-recipe-cooktime', $this->post);
        if (!empty($cookTime)) {
            $items[] = $this->addCardItem(
                'Temps de cuisson',
                date('i', strtotime($cookTime)) . ' min.',
                'clock-o'
            );
        }

        $ingredients = [];
        while (have_rows('entity-value-recipe-ingredients', $this->post)) {
            the_row();
            $ingredients[] = get_sub_field('entity-ingredient-name');
        }
        $items[] = $this->addCardItem(
            'Ingrédients',
            implode(' — ', array_filter($ingredients)),
            'tags'
        );

        return $items;
    }

    private function getInstructionHtml($instructionData)
    {
        $listId = [];

        if (!empty($instructionData['entity-instruction-gallery'])) {
            foreach ($instructionData['entity-instruction-gallery'] as $image) {
                if (!empty($image['ID'])) {
                    $listId[] = $image['ID'];
                }
            }
        }

        return sprintf(
            '<li>%s%s</li>',
            $instructionData['entity-instruction-text'],
            !empty($listId) ? do_shortcode(
                sprintf(
                    '[gallery ids="%s" columns="5"]',
                    implode(',', $listId)
                )
            ) : ''
        );
    }
}
