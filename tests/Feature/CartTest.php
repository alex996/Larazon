<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItStoresCartAndReturnsItsUuidWithCookie()
    {
        // When
        $response = $this->postJson(route('carts.store'), []);
        $uuid = array_get($response->getOriginalContent(), 'data.uuid');

        // Then
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'uuid'
                ]
            ])
            ->assertCookie(
                'uuid', $uuid
            );

        $this->assertDatabaseHas('carts', [
            'uuid' => $uuid
        ]);
    }

    public function testItRejectsRequestIfCookieIsSet()
    {
        // Given
        $cart = factory(Cart::class)->create();

        // When
        $response = $this->call('POST', route('carts.store'), [], [
            'uuid' => Crypt::encrypt($cart->uuid)
        ]);

        // Then
        $response->assertStatus(400);
    }
}
