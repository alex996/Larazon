<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItReturnsCategoriesArray()
    {
        // Given
        $categories = factory(Category::class, 10)->create();

        // When
        $response = $this->get(route('categories.index'));

        // Then
        $response->assertJson($categories->toArray());
    }
}
