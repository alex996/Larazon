<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItStoresCartAndReturnsItsUuidWithCookie()
    {
        // When
        $response = $this->postJson(route('carts.store'), []);

        // Then
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'uuid'
                ]
            ]);

        $this->assertDatabaseHas('carts', [
            'uuid' => array_get(
                $response->getOriginalContent(), 'data.uuid'
            )
        ]);
    }
}
