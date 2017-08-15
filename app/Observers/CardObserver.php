<?php

namespace App\Observers;

use App\Models\Card;

class CardObserver
{
    /**
     * Listen to the Card creating event.
     *
     * @param  Card  $card
     * @return void
     */
    public function creating(Card $card)
    {
        // Whenever a card is created, auto-generate its uid, if needed
        if (! $card->isDirty('uid')) {
            $card->uid = str_random(14);
        }
    }
}