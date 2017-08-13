<?php

namespace App\Http\Transformers;

use App\Models\Address;
use App\Repositories\GeoRepository;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    protected $geo;

    public function __construct(GeoRepository $geo)
    {
        $this->geo = $geo;
    }

    /**
     * Turn this item object into a generic array.
     *
     * @param  Address  $address
     * @return array
     */
    public function transform(Address $address)
    {
        return [
            'line_1' => $address->line_1,
            'line_2' => $address->line_2,
            'city' => $address->city,
            'state' => $address->state,
            'state_pretty' => $this->geo->getStateName($address->state),
            'country' => $address->country,
            'country_pretty' => $this->geo->getCountryName($address->country),
            'zip' => $address->zip,
        ];
    }
}