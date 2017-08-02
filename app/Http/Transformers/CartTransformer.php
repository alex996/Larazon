<?php

namespace App\Http\Transformers;

use App\Models\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param  Cart  $cart
     * @return array
     */
    public function transform(Cart $cart)
    {
        return [
            'uuid' => $cart->uuid,
        ];
    }
}