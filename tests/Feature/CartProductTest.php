<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartProductTest extends TestCase
{
    use RefreshDatabase;

    /*******************************************************************
    ******************************* POST *******************************
    *******************************************************************/

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

    public function testItDoesNotAddProductIfItsAlreadyInCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->make();
        $cart->products()->save($product, ['quantity' => 1]);

        // When
        $response = $this->postJson(route('cart-products.store', [$cart]), [
            'slug' => $product->slug,
            'quantity' => 2
        ]);

        // Then
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'slug'
                ]
            ]);
    }

    public function testItDoesNotAddProductIfQuantityExceedsStock()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->create([
            'quantity' => 999
        ]);

        // When
        $response = $this->postJson(route('cart-products.store', [$cart]), [
            'slug' => $product->slug,
            'quantity' => 1000
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

    public function testItDoesNotAddProductIfSlugIsInvalid()
    {
        // Given
        $cart = factory(Cart::class)->create();

        // When
        $response = $this->postJson(route('cart-products.store', [$cart]), [
            'slug' => 'a-random-non-existent-product-slug',
        ]);

        // Then
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'slug'
                ]
            ]);
    }

    /*******************************************************************
    ****************************** PATCH *******************************
    *******************************************************************/

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

    public function testItDoesNotUpdateProductIfSlugIsInvalid()
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

    public function testItDoesNotUpdateProductIfItIsNotInCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->create();

        // When
        $response = $this->patchJson(route('cart-products.update', [$cart, $product]), [
            'quantity' => 1
        ]);

        // Then
        $response->assertStatus(404);
    }

    public function testItDoesNotUpdateProductIfQuantityDidntChange()
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
    }

    public function testItDoesNotUpdateProductIfQuantityExceedsStock()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->make([
            'quantity' => 999
        ]);
        $cart->products()->save($product, [
            'quantity' => 1
        ]);

        // When
        $response = $this->patchJson(route('cart-products.update', [$cart, $product]), [
            'quantity' => 1000
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

    /*******************************************************************
    ***************************** DELETE *******************************
    *******************************************************************/

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

    public function testItDoesNotDeleteProductIfItIsNotInCart()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $product = factory(Product::class)->create();

        // When
        $response = $this->deleteJson(route('cart-products.destroy', [$cart, $product]));

        // Then
        $response->assertStatus(404);
    }

    /*******************************************************************
    ***************************** INDEX ********************************
    *******************************************************************/

    public function testItShowsCollectionOfCartProducts()
    {
        // Given
        $cart = factory(Cart::class)->create();
        $products = factory(Product::class, 10)->make()
            ->each(function($product) use ($cart) {
                $cart->products()->save($product, [
                    'quantity' => 1
                ]);
            });

        // When
        $response = $this->getJson(route('cart-products.index', [$cart]));

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['name', 'slug', 'description', 'price', 'quantity']
                ],
            ]);
    }
}
