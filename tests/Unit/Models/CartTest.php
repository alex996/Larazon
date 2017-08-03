<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function itAddsItemWithProductIdAndQuantity()
    {
        // Given
        $product = factory(Product::class)->create();
        $cart = factory(Cart::class)->create();
        $productQuantity = 1;

        // When
        $item = new CartItem;
        $item->product_id = $product->id;
        $item->quantity = $productQuantity;
        $cart->addItem($item);

        // Then
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $productQuantity,
        ]);
    }
}
