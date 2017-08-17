<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Address, Card, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesCustomerWithNewCard()
    {
        // Given
        $jwtToken = $this->getJwtToken(
            $user = factory(User::class)->create()
        );
        $stripeToken = $this->getStripeToken();

        // When
        $response = $this->postJson(route('cards.store'), [
            'token' => $stripeToken->id
        ], [
            'Authorization' => 'Bearer '.$jwtToken
        ]);
        $user = $user->fresh();

        // Then
        $response->assertStatus(201);

        $this->assertTrue($user->hasStripeId());
        $this->assertTrue($user->hasCardOnFile());
    }

    public function testItAddsNewCardToExistingCustomer()
    {
        // Given
        $jwtToken = $this->getJwtToken(
            $user = factory(User::class)->create()
        );
        $user->createCustomerWithCard(
            $this->getVisaToken()->id
        );
        $stripeToken = $this->getMasterCardToken();

        // When
        $response = $this->postJson(route('cards.store'), [
            'token' => $stripeToken->id
        ], [
            'Authorization' => 'Bearer '.$jwtToken
        ]);
        $user = $user->fresh();
        
        // Then
        $response->assertStatus(201);

        $this->assertEquals($user->cards->count(), 2);
        $this->assertEquals($user->cards->last()->stripe_id, $stripeToken->card->id);
    }

    /*public function testItDoesNotAddTheSameCardToCustomer()*/

    public function testItReturnsUsersCardsWithBillingAddresses()
    {
        // Given
        $jwtToken = $this->getJwtToken(
            $user = factory(User::class)->create()
        );
        $user->cards()->saveMany(
            factory(Card::class, 10)->create()->each(function($card) {
                $card->address()->save(
                    factory(Address::class)->make()
                );
            })
        );

        // When
        $response = $this->getJson(route('cards.index'), [
            'Authorization' => 'Bearer '.$jwtToken
        ]);

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'uid', 'brand', 'last4', 'country', 'exp_month', 'exp_year', 'default',
                        'address' => [
                            'data' => [
                                'line_1', 'line_2', 'city', 'state', 'state_pretty', 'country', 'country_pretty', 'zip'
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
