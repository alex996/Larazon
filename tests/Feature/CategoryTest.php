<?php

namespace Tests\Feature;

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
    public function testItTransformsAndPaginatesCategories()
    {
        // Given
        $categories = factory(Category::class, 10)->create();

        // When
        $response = $this->getJson(route('categories.index'));

        // Then
        $response->assertJsonStructure([
            'data' => [
                ['slug', 'name']
            ],
            'meta' => [
                'pagination' => [
                    'total', 'count', 'per_page', 'current_page', 'total_pages', 'links'
                ]
            ],
        ]);
    }
}
