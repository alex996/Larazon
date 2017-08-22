<?php

namespace App\Http\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    protected $addressTransformer;

    protected $cardTransformer;

    /**
     * Create a new transformer instance.
     *
     * @return  @void
     */
    public function __construct(
        AddressTransformer $addressTransformer,
        CardTransformer $cardTransformer
    ) {
        $this->addressTransformer = $addressTransformer;
        $this->cardTransformer = $cardTransformer;
    }

    /**
     * List of resources to automatically include.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'address',
        'card'
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @param  Order  $order
     * @return array
     */
    public function transform(Order $order)
    {
        return [        
            'status' => $order->status,
            'subtotal' => $order->subtotal,
            'shipping' => $order->shipping,
            'tax' => $order->tax,
            'total' => $order->total,
            'created_at' => $order->created_at,
            'shipped_at' => $order->shipped_at,
            'delivered_at' => $order->delivered_at,
        ];
    }

    /**
     * Include Address.
     *
     * @param Order $order
     * @return \League\Fractal\Resource\Item
     */
    public function includeAddress(Order $order)
    {
        $address = $order->address;

        if (! $address) {
            return $this->null();
        }

        return $this->item($address, $this->addressTransformer);
    }

    /**
     * Include Card.
     *
     * @param Order $order
     * @return \League\Fractal\Resource\Item
     */
    public function includeCard(Order $order)
    {
        $card = $card->card;

        if (! $card) {
            return $this->null();
        }

        return $this->item($card, $this->cardTransformer);
    }
}