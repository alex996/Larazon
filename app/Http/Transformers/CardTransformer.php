<?php

namespace App\Http\Transformers;

use App\Models\Card;
use League\Fractal\TransformerAbstract;

class CardTransformer extends TransformerAbstract
{
    protected $addressTransformer;

    /**
     * Create a new transformer instance.
     *
     * @return  @void
     */
    public function __construct(AddressTransformer $transformer)
    {
        $this->addressTransformer = $transformer;
    }

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'address'
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @param  Card  $card
     * @return array
     */
    public function transform(Card $card)
    {
        return [
            'uid' => $card->uid,
            'brand' => $card->brand,
            'last4' => $card->last4,
            'country' => $card->country,
            'exp_month' => $card->exp_month,
            'exp_year' => $card->exp_year,
            'default' => $card->default,
        ];
    }

    /**
     * Include Address
     *
     * @param Card $card
     * @return \League\Fractal\Resource\Item
     */
    public function includeAddress(Card $card)
    {
        $address = $card->address;

        if (! $address) {
            return $this->null();
        }

        return $this->item($address, $this->addressTransformer);
    }
}