<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItAddsProductToCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->create();
        $quantity = 1;

        // When
        $response = $this->postJson(route('cart-products.store', [$cart]), [
            'slug' => $product->slug,
            'quantity' => $quantity
        ]);

        // Then
        $response->assertStatus(201);
        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);
    }

    public function testItDoesNotAddProductIfCartNotFound()
    {
        // Given
        $cartUuid = 'a-random-non-existent-cart-uuid';

        // When
        $response = $this->postJson(
            route('cart-products.store', ['cart' => $cartUuid])
        );

        // Then
        $response->assertStatus(404);
    }

    //public function testItDoesNotAddProductIfItIsAlreadyInCart()

    public function testItUpdatesProductInCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->make();
        $cart->products()->save($product, [
            'quantity' => 1
        ]);
        $newProductQuantity = 2;

        // When
        $response = $this->patchJson(route('cart-products.update', [$cart, $product]), [
            'quantity' => $newProductQuantity
        ]);

        // Then
        $response->assertStatus(204);
        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $newProductQuantity
        ]);
    }

    public function testItDoesNotUpdateProductIfItDoesNotExist()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $slug = 'a-random-non-existent-product-slug';

        // When
        $response = $this->patchJson(route('cart-products.update', [
            'cart' => $cart->uuid,
            'product' => $slug
        ]));

        // Then
        $response->assertStatus(404);
    }

    //public function testItDoesNotUpdateProductIfItIsNotInCart()

    /*public function testItDoesNotUpdateProductIfQuantityDidntChange()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->make();
        $cart->products()->save($product, [
            'quantity' => 1
        ]);

        // When
        $response = $this->patchJson(route('cart-products.update', [$cart, $product]), [
            'quantity' => 1
        ]);

        // Then
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'quantity'
                ]
            ]);
    }*/

    public function testItDeletesProductFromCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->make();
        $cart->products()->save($product, [
            'quantity' => 1
        ]);

        // When
        $response = $this->deleteJson(route('cart-products.destroy', [$cart, $product]));

        // Then
        $response->assertStatus(204);
        $this->assertDatabaseMissing('cart_product', [
            'cart_id' => $cart->id,
            'product_id' => $product->id
        ]);
    }

    //public function testItDoesNotDeleteProductIfItIsNotInCart()
}
