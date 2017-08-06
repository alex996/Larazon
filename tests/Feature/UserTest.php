<?php

namespace Tests\Feature;

use Tests\TestCase;
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
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    //public function testItDoesNotCreateUserWhenLoggedIn()
}
