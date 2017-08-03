<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartItemTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItAddsItemToCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->create();
        $productQuantity = 1;

        // When
        $response = $this->call('POST', route('cart-items.store', ['uuid' => $cart->uuid]), [], [
            'uuid' => Crypt::encrypt($cart->uuid)
        ], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json'
        ], json_encode([
            'product_id' => $product->id,
            'quantity' => $productQuantity
        ]));

        // Then
        $response->assertStatus(201);
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $productQuantity
        ]);
    }

    //public function testItRejects
}
