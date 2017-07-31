<?php

namespace Tests\Feature\Api;

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
    public function testItTransformsProducts()
    {
        // Given
        $products = factory(Product::class, 10)->create();

        // When
        $response = $this->get(route('products.index'));

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['name', 'description', 'price', 'quantity']
                ],
            ]);
    }

    public function testItTransformsSingleProduct()
    {
        // Given
        $product = factory(Product::class)->create();

        // When
        $response = $this->get(route('products.show', [$product]));
        
        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name', 'description', 'price', 'quantity'
                ],
            ]);
    }
}
