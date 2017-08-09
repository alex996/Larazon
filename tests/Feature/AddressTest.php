<?php

namespace Tests\Feature;

use JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    public function setUp()
    {
        parent::setUp();

        $this->token = JWTAuth::fromUser(factory(User::class)->create());
    }

    public function testItCreatesAddress()
    {
        // Given
        $address = factory(Address::class)->raw();

        // When
        $response = $this->postJson(route('addresses.store'), $address, [
            'Authorization' => 'Bearer '.$this->token
        ]);

        // Then
        $response->assertStatus(201)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseHas('addresses', $address);
    }

    public function testItDoesNotCreateAddressIfNotLoggedIn()
    {
        // When
        $response = $this->postJson(route('addresses.store'));
        
        // Then
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Token Not Provided.'
            ]);
    }
}
