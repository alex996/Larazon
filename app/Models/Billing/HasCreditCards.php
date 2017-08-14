<?php

namespace App\Models\Billing;

use App\Models\Card;
use Stripe\Card as StripeCard;

trait HasCreditCards
{
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function hasCardOnFile()
    {
        return $this->cards()->exists();
    }

    public function addCard(StripeCard $card)
    {
        $userCard = Card::forceCreate([
            'stripe_id' => $card->id,
            'user_id' => $this->id,
            'brand' => $card->brand,
            'last4' => $card->last4,
            'country' => $card->country,
            'exp_month' => $card->exp_month,
            'exp_year' => $card->exp_year,
            'default' => ! $this->hasCardOnFile(),
        ]);

        $userCard->address()->create([
            'line_1' => $card->address_line1,
            'line_2' => $card->address_line2,
            'city' => $card->address_city,
            'state' => $card->address_state,
            'country' => $card->address_country,
            'zip' => $card->address_zip
        ]);

        return $userCard;
    }
}