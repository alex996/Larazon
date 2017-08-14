<?php

namespace Tests\Concerns;

use Stripe\Token;
use App\Models\{Address, Card};

trait InteractsWithStripe
{
    protected $cards = [
        'visa' => [
            '4242424242424242',
            '5555555555554444',
            '4000056655665556',
        ],
        'master' => [
            '5555555555554444',
            '5200828282828210',
            '5105105105105100',
        ],
        'amex' => [
            '378282246310005',
            '371449635398431',
        ],
        'discover' => [
            '6011111111111117',
            '6011000990139424',
        ]
    ];

    protected function getStripeToken($brand = null)
    {
        $brand = $brand ?: array_rand($this->cards);
        $index = array_rand($this->cards[$brand]);
        $cardNumber = $this->cards[$brand][$index];

        $card = factory(Card::class)->make();
        $address = factory(Address::class)->make();

        return Token::create([
            'card' => [
                'number' => $cardNumber,
                'exp_month' => $card->exp_month,
                'exp_year' => $card->exp_year,
                'cvc' => 123,
                'address_line1' => $address->line_1,
                'address_line2' => $address->line_2,
                'address_city' => $address->city,
                'address_state' => $address->state,
                'address_country' => $address->country,
                'address_zip' => $address->zip,
            ]
        ]);
    }

    public function getVisaToken()
    {
        return $this->getStripeToken('visa');
    }

    public function getMasterCardToken()
    {
        return $this->getStripeToken('master');
    }
}