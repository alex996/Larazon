<?php

namespace Tests\Unit\Observers;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItGeneratesUniqueSlugWhenCreating()
    {
        // Given
        $uniqueName = 'A unique name that certainly does not exist';

        // When
        $product = factory(Product::class)->create([
            'name' => $uniqueName
        ]);

        // Then
        $this->assertEquals($product->slug, str_slug($product->name));
    }

    public function testItGeneratesUniqueSlugWhenUpdating()
    {
        // Given
        $product = factory(Product::class)->create();
        $oldName = $product->name;

        // When
        $product->update(['name' => 'Another unique non-existent name']);

        // Then
        $this->assertEquals($product->slug, str_slug($product->name));
        $this->assertNotEquals($product->slug, str_slug($product->oldName));
    }

    public function testItAppendsCountToSlugIfItAlreadyExists()
    {
        // Given
        $count = 7;
        $name = 'Lorem ispum dolor sit amet';
        $product = factory(Product::class, $count)->create([
            'name' => $name
        ]);

        // When
        $sameProduct = factory(Product::class)->create([
            'name' => $name
        ]);

        // Then
        $this->assertEquals($sameProduct->slug, $product->first()->slug.'-'.$count);
    }
}
