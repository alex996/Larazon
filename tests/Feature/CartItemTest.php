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
            'slug' => $product->slug,
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

        // When
        $response = $this->postJson(
            route('cart-items.store', ['cart' => $cartUuid])
        );

        // Then
        $response->assertStatus(404);
    }

    public function testItUpdatesItemQuantityInCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $cartItem = factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'quantity' => 1
        ]);
        $newProductQuantity = 2;

        // When
        $response = $this->patchJson(route('cart-items.update', [$cart, $cartItem]), [
            'quantity' => $newProductQuantity
        ]);

        // Then
        $response->assertStatus(200);
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'cart_id' => $cart->id,
            'product_id' => $cartItem->product_id,
            'quantity' => $newProductQuantity
        ]);
    }

    public function testItDoesNotUpdateQuantityIfCartItemNotFound()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $cartItemProductId = 999;

        // When
        $response = $this->patchJson(route('cart-items.update', [
            'cart' => $cart->uuid,
            'item' => $cartItemProductId
        ]));

        // Then
        $response->assertStatus(404);
    }
    
    public function testItDoesNotUpdateQuantityIfItDidntChange()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $cartItem = factory(CartItem::class)->create([
            'cart_id' => $cart->id,
            'quantity' => 1
        ]);
        $newProductQuantity = $cartItem->quantity;

        // When
        $response = $this->patchJson(route('cart-items.update', [$cart, $cartItem]), [
            'quantity' => $newProductQuantity
        ]);

        // Then
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'quantity'
                ]
            ]);
    }
}
