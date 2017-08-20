<?php

namespace App\Models\Billing;

use Stripe\Charge;
use App\Models\Order;

trait HasOrders
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function placeOrder(Address $address, Card $card)
    {
        //
    }
}