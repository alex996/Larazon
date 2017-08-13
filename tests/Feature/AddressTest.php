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

    protected $user;

    protected $token;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'name' => 'Alex Jones'
        ]);

        $this->token = JWTAuth::fromUser($this->user);
    }

    /*******************************************************************
    ******************************* POST *******************************
    *******************************************************************/

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

    /*******************************************************************
    ***************************** DELETE *******************************
    *******************************************************************/

    public function testItDeletesAddress()
    {
        // Given
        $this->user->addresses()->save(
            $address = factory(Address::class)->make()
        );

        // When
        $response = $this->deleteJson(route('addresses.destroy', [$address]), [], [
            'Authorization' => 'Bearer '.$this->token
        ]);

        // Then
        $response->assertStatus(200);

        $this->assertDatabaseMissing('addresses', [
            'id' => $address->id,
        ]);
    }

    public function testItDoesNotDeleteAddressIfUserDoesntOwnIt()
    {
        // Given
        $address = factory(Address::class)->create([
            'user_id' => 999
        ]);

        // When
        $response = $this->deleteJson(route('addresses.destroy', [$address]), [], [
            'Authorization' => 'Bearer '.$this->token
        ]);

        // Then
        $response->assertStatus(403);

        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
        ]);
    }

    /*******************************************************************
    ***************************** INDEX ********************************
    *******************************************************************/

    public function testItReturnsCollectionOfAddresses()
    {
        // Given
        $this->user->addresses()->saveMany(
            factory(Address::class, 10)->make()
        );

        // When
        $response = $this->getJson(route('addresses.index'), [
            'Authorization' => 'Bearer '.$this->token
        ]);

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['street', 'street_2', 'city', 'state', 'state_pretty', 'country', 'country_pretty', 'zip']
                ],
                'meta' => [
                    'pagination' => [
                        'total', 'count', 'per_page', 'current_page', 'total_pages', 'links'
                    ]
                ],
            ]);
    }
}
