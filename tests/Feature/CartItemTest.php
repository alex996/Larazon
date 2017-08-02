<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItAddsItemToCart()
    {
        // Given
        $cart = factory(Cart::class)->create();

        // When
        $this->call('POST', route('cart-items.store', [$cart]), [], [
            'uuid' => Crypt::encrypt($cart->uuid)
        ]);



        // Then
    }

    //public function testItRejects
}
