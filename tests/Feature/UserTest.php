<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = $this->app->make(Faker::class);
    }

    public function testItCreatesUserAccount()
    {
        // Given
        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->password;
        $password_confirmation = $password;

        // When
        $response = $this->postJson(
            route('users.store'),
            compact('name', 'email', 'password', 'password_confirmation')
        );

        // Then
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', compact('name', 'email'));
    }

    public function testItDoesNotCreateUserIfValidationFails()
    {
        // When
        $response = $this->postJson(route('users.store'), [
            'name' => null,
            'email' => 'random-string',
            'password' => 'short'
        ]);

        // Then
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name', 'email', 'password'
                ]
            ]);
    }

    public function testItDoesNotCreateUserWhenLoggedIn()
    {
        // Given
        $token = $this->getJwtToken();

        // When
        $response = $this->postJson(route('users.store'), [], [
            'Authorization' => 'Bearer '.$token
        ]);

        // Then
        $response->assertStatus(403);
    }
}
