<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Crypt;
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
        // Given
        //$this

        // When
        $response = $this->postJson(route('carts.store'), []);
        $uuid = array_get($response->getOriginalContent(), 'data.uuid');

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'uuid'
                ]
            ])
            ->assertCookie(
                'uuid', $uuid, false
            );

        $this->assertDatabaseHas('carts', [
            'uuid' => $uuid
        ]);
    }
}
