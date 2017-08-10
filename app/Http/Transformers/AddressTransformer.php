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
            'type' => $address->type,
            'street' => $address->street,
            'street_2' => $address->street_2,
            'city' => $address->city,
            'state' => $address->state,
            'state_pretty' => $this->geo->getStateName($address->state),
            'country' => $address->country,
            'country_pretty' => $this->geo->getCountryName($address->country),
            'zip' => $address->zip,
        ];
    }
}