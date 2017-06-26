<?php

namespace Theme\Unemanettealamain\Entities;

require_once 'LocalBusiness.php';

class LodgingBusiness extends LocalBusiness
{
    public function getValues()
    {
        return array_merge(
            parent::getValues(),
            [
                'checkinTime' => ['property' => 'entity-value-lodging-checkin'],
                'checkoutTime' => ['property' => 'entity-value-lodging-checkout']
            ]
        );
    }
}
