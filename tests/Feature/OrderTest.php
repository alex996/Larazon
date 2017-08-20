<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Address, Card, Cart, Product, User};

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testItPlacesAnOrder()
    {
        // Given
        $user = factory(User::class)->create();
        $token = $this->getJwtToken($user);
        $cart = $user->carts()->save(
            factory(Cart::class)->make()
        );
        factory(Product::class, 5)->make()->each(function($product) use ($cart) {
            $cart->products()->save($product, [
                'quantity' => 1
            ]);
        });
        $user->addresses()->save($address = factory(Address::class)->make());
        $user->cards()->save($card = factory(Card::class)->make());
        
        // When
        $response = $this->post(route('orders.store'), [
            'cart' => $cart->uuid,
            'card' => $card->uid,
            'address' => $address->uid,
        ], [
            'Authorization' => 'Bearer '.$token
        ]);

        // Then
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'card_id' => $card->id,
            'address_id' => $address->id
        ]);
    }

    //public function testItDeniesOrderPlacementWhenGivenBadCard
}
