<?php

namespace App\Http\Transformers;

use App\Models\CartItem;
use League\Fractal\TransformerAbstract;

class CartItemTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'product'
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @param  CartItem  $item
     * @return array
     */
    public function transform(CartItem $item)
    {
        return [
            'quantity' => $item->quantity
        ];
    }

    /**
     * Include Product
     *
     * @param  CartItem $item
     * @return League\Fractal\ItemResource
     */
    public function includeProduct(CartItem $item)
    {
        return $this->item($item->product, new ProductTransformer);
    }
}