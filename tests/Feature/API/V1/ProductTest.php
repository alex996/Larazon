<?php

namespace Tests\Feature\API\V1;

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
        $response = $this->get('api/v1/products');

        // Then
        $response->assertJson($products->toArray());
    }
}
