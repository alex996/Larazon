<?php

namespace Tests\Unit\Models\Billing;

use Tests\TestCase;
use App\Models\{Card, User};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasCreditCardsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testItHasCards()
    {
        $this->user->cards()->saveMany(
            factory(Card::class, 5)->make()
        );

        $this->assertInstanceOf(Collection::class, $this->user->cards);

        $this->assertInstanceOf(Card::class, $this->user->cards->first());
    }

    public function testItAddsStripeCardToUser()
    {
        // Given
        $token = $this->getStripeToken();
        $stripeCard = $token->card;
        // When
        $card = $this->user->addCard($token->card);
        // Then
        $this->assertNotEmpty($card);
        $this->assertDatabaseHas('cards', [
            'stripe_id' => $stripeCard->id,
            'user_id' => $this->user->id,
            'brand' => $stripeCard->brand,
            'last4' => $stripeCard->last4,
            'country' => $stripeCard->country,
            'exp_month' => $stripeCard->exp_month,
            'exp_year' => $stripeCard->exp_year,
            'default' => true
        ])
        ->assertDatabaseHas('addresses', [
            'addressable_id' => $card->id,
            'addressable_type' => 'cards',
            'line_1' => $stripeCard->address_line1,
            'line_2' => $stripeCard->address_line2,
            'city' => $stripeCard->address_city,
            'state' => $stripeCard->address_state,
            'country' => $stripeCard->address_country,
            'zip' => $stripeCard->address_zip,
        ]);
    }
}
