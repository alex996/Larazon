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
        $response = $this->postJson(route('cart-items.store', [$cart]), [
            'product_id' => $product->id,
            'quantity' => $productQuantity
        ]);

        // Then
        $response->assertStatus(201);
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $productQuantity
        ]);
    }

    public function testDoesNotAddItemIfCartNotFound()
    {
        // Given
        $cartUuid = 'a-random-non-existent-cart-uuid';
        $product = factory(Product::class)->create();
        $productQuantity = 1;

        // When
        $response = $this->postJson(
            route('cart-items.store', ['cart' => $cartUuid]), 
            [
                'product_id' => $product->id,
                'quantity' => $productQuantity
            ]
        );

        // Then
        $response->assertStatus(404);
    }
}
