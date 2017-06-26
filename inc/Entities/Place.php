<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'Thing.php';

class Place extends Thing
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'address' => ['type' => 'Object', 'values' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => ['property' => 'entity-value-adress-street'],
                    'postalCode' => ['property' => 'entity-value-adress-postalcode'],
                    'addressLocality' => ['property' => 'entity-value-adress-locality'],
                    'addressCountry' => ['property' => 'entity-value-adress-country']
                ]],
                'geo' => ['type' => 'GeoCoordinates', 'property' => 'entity-value-geo'],
                'telephone' => ['property' => 'entity-value-telephone'],
                'openingHoursSpecification' => ['type' => 'Repeater', 'property' => 'entity-value-openinghours', 'values' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['property' => 'entity-opening-dayweek'],
                    'opens' => ['type' => 'Time', 'property' => 'entity-opening-opens'],
                    'closes' => ['type' => 'Time', 'property' => 'entity-opening-closes'],
                    'validFrom' => ['property' => 'entity-opening-validfrom'],
                    'validThrough' => ['property' => 'entity-opening-validthrough']
                ]],
                'photo' => ['type' => 'Gallery', 'property' => 'entity-value-photos']
            ]
        );
    }

    protected function getCardItems()
    {
        if (!class_exists('acf')) {
            return[];
        }

        $items = [
            $this->addCardItem(
                'Adresse',
                $this->getAdressText(),
                'map-marker'
            ),
            $this->addCardItem(
                'Téléphone',
                get_field('entity-value-telephone', $this->post),
                'phone'
            ),
            $this->addCardItem(
                "Horaires d'ouverture",
                get_field('entity-value-openinghours-text', $this->post),
                'clock-o'
            )
        ];

        $mapUrl = $this->getMapsUrl();
        if (!empty($mapUrl)) {
            $items[] = $this->addCardItem(
                'Localisation',
                sprintf(
                    '<a href="%s" rel="nofollow">Voir sur Google Maps</a>',
                    $mapUrl
                ),
                'map-o'
            );
        }

        return array_merge(
            $items,
            parent::getCardItems()
        );
    }

    /**
     * Get reading text of address
     *
     * @return string
     */
    private function getAdressText()
    {
        $street = get_field('entity-value-adress-street', $this->post);
        $postal = get_field('entity-value-adress-postalcode', $this->post);
        $city = get_field('entity-value-adress-locality', $this->post);
        $country = get_field('entity-value-adress-country', $this->post);

        $separator = !empty($street) && (!empty($postal) || !empty($city) || !empty($country)) ? ' — ' : '';

        if (!empty($city) && !empty($postal)) {
            $city = ' ' . $city;
        }

        if (!empty($country) && (!empty($postal) || !empty($city))) {
            $country = ', ' . $country;
        }

        return sprintf(
            '%s%s%s%s%s',
            $street,
            $separator,
            $postal,
            $city,
            $country
        );
    }

    /**
     * Get Google map's URL of the place
     *
     * @return string
     */
    private function getMapsUrl()
    {
        $map = get_field('entity-value-geo', $this->post);

        if (empty($map['address'])) {
            return '';
        }

        return sprintf(
            'https://www.google.fr/maps/place/%s',
            urlencode($map['address'])
        );
    }
}
