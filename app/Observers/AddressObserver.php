<?php

namespace App\Observers;

use App\Models\Address;

class AddressObserver
{
    /**
     * Listen to the Address creating event.
     *
     * @param  Address  $address
     * @return void
     */
    public function creating(Address $address)
    {
        // Whenever an address is created, auto-generate its uid, if needed
        if (! $address->isDirty('uid')) {
            $address->uid = str_random(14);
        }
    }
}