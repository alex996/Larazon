<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItTransformsAndPaginatesProducts()
    {
        // Given
        $products = factory(Product::class, 10)->create();

        // When
        $response = $this->getJson(route('products.index'));

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['name', 'slug', 'description', 'price', 'quantity']
                ],
                'meta' => [
                    'pagination' => [
                        'total', 'count', 'per_page', 'current_page', 'total_pages', 'links'
                    ]
                ],
            ]);
    }

    public function testItTransformsAndReturnsProduct()
    {
        // Given
        $product = factory(Product::class)->create();

        // When
        $response = $this->getJson(route('products.show', [$product]));
        
        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name', 'slug', 'description', 'price', 'quantity'
                ],
            ]);
    }

    public function testItResolvesProductBySlug()
    {
        // Given
        $product = factory(Product::class)->create();

        // When
        $responseSuccess = $this->getJson(route('products.show', ['slug' => $product->slug]));
        $responseNotFound = $this->getJson(route('products.show', ['id' => $product->id]));

        // Then
        $responseSuccess->assertStatus(200);
        $responseNotFound->assertStatus(404);
    }
}
