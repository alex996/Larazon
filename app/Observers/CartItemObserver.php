<?php

namespace App\Observers;

use App\Models\CartItem;

class CartItemObserver
{
    /**
     * Listen to the CartItem creating event.
     *
     * @param  CartItem  $item
     * @return void
     */
    public function creating(CartItem $item)
    {
        // Whenever a cart item is created, auto-generate its uid, if needed
        if (! $item->isDirty('uid')) {
            $item->uid = bin2hex(random_bytes(6));
        }
    }
}