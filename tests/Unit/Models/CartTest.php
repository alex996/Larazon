<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\{Cart, Product};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testItCalculatesSubtotal()
    {
        // Given
        $cart = factory(Cart::class)->create();
        factory(Product::class, 3)->make()->each(function($product) use ($cart) {
            $cart->products()->save($product, ['quantity' => rand(1, 5)]);
        });
        $expected = 0;
        foreach($cart->products as $product) {
            $expected += $product->price * $product->pivot->quantity;
        }
        // When
        $subtotal = $cart->subtotal();
        // Then
        $this->assertEquals($subtotal, $expected);
    }
}
