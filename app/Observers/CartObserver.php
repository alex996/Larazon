<?php

namespace App\Observers;

use App\Models\Cart;
use Ramsey\Uuid\Uuid;

class CartObserver
{
    /**
     * Listen to the Cart creating event.
     *
     * @param  Cart  $cart
     * @return void
     */
    public function creating(Cart $cart)
    {
        // Whenever a cart is created, auto-generate its uuid, if needed
        if (! $cart->isDirty('uuid')) {
            $cart->uuid = Uuid::uuid5(
                Uuid::NAMESPACE_DNS, config('app.url')
            )->toString();
        }
    }
}