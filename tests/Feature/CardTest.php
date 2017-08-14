<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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
        $stripeCard = $stripeToken->card;

        // When
        $response = $this->postJson(route('cards.store'), [
            'token' => $stripeToken->id
        ], [
            'Authorization' => 'Bearer '.$jwtToken
        ]);
        $user = $user->fresh();
        $card = $user->cards()->first();

        // Then
        $response->assertStatus(201);

        $this->assertTrue($user->hasStripeId());
        $this->assertTrue($user->hasCardOnFile());
        $this->assertNotEmpty($card);
        
        $this->assertDatabaseHas('cards', [
                'stripe_id' => $stripeCard->id,
                'user_id' => $user->id,
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

        // 1. it creates Stripe customer
        // 2. it saves stripe_id on user
        // 3. it adds card to Stripe customer
        // 4. it saves card locally with billing addr.

        //$this->assertTrue($user->hasStripeId());
        //$this->assertTrue($user->hasCardOnFile());
    }

    /*public function testItUpdatesCustomerByAddingNewCard()
    {
        // Given
        $user = $this->user;
        $token = $this->getMasterCardToken();

        // When
        $response = $this->postJson(route('cards.store'), [
            'token' => $token->id
        ], [
            'Authorization' => 'Bearer '.$this->token
        ]);
        
        // Then
        $response->assertStatus(201);

        // Local DB
        //$this->assertEquals($user->cards()->count(), 2);
        $this->assertDatabaseHas('cards', [
            'stripe_id' => $token->card->id,
            'user_id' => $user->id,
            'last4' => $token->card->last4,
        ]);
dd($user);
        // Stripe
        $customer = $user->asStripeCustomer();
        dd($customer);
    }*/

    /*public function testItCreatesCustomerWithCardDetails()
    {
        // Given
        $token = $this->getStripeToken();

        // When
        $response = $this->postJson(route('cards.store'), array_merge([
            'token' => $token->id
        ]), [
            'Authorization' => 'Bearer '.$this->token
        ]);

        // Then
        $response->assertStatus(201);
    }*/

    /*public function testItCreatesCustomerWithCardDetails()
    {
        // Given
        $address = factory(Address::class)->make();
        $stripeToken = Token::create([
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 1,
                'exp_year' => 2019,
                'cvc' => 123,
                'address_line1' => $address->street,
                'address_line2' => $address->street_2,
                'address_city' => $address->city,
                'address_state' => $address->state,
                'address_country' => $address->country,
                'address_zip' => $address->zip,
            ]
        ]);

        // When
        $response = $this->postJson(route('cards.store'), array_merge([
            'token' => $stripeToken,
        ], $address->toArray()), [
            'Authorization' => 'Bearer '.$this->token
        ]);

        // Then
        $user->fresh();

        $response->assertStatus(200);

        $this->assertTrue($user->hasStripeId());
    }*/

    // public function testItAddsNewCardToExistingCustomer
}
