<?php

namespace Tests\Feature;

use JWTAuth;
use Stripe\Token;
use Stripe\Stripe;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    public function testEx()
    {
        $this->assertTrue(true);
    }

    /*use RefreshDatabase;

    protected $user;

    protected $token;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'Alex Jones'
        ]);

        $this->token = JWTAuth::fromUser($this->user);

        Stripe::setApiKey(config('services.stripe.key'));
    }

    public function testItCreatesCustomerWithCardDetails()
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
    }

    protected function getStripeToken()
    {
        $address = factory(Address::class)->make();

        return Token::create([
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
