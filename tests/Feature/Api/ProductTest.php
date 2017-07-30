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
    public function testItReturnsProductsArray()
    {
        // Given
        $products = factory(Product::class, 10)->create();

        // When
        $response = $this->get(route('products.index'));

        // Then
        $response->assertJsonStructure([
            'data' => [
                ['name', 'description', 'price', 'quantity']
            ],
        ]);
    }
}
