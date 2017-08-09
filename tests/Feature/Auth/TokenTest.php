<?php

namespace Tests\Feature\Auth;

use JWTAuth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    public function testItIssuesTokenToRegisteredUsers()
    {
        // Given
        $password = 'secret';
        $user = factory(User::class)->create([
            'password' => Hash::make($password)
        ]);

        // When
        $response = $this->postJson(route('auth-token.issue'), [
            'email' => $user->email,
            'password' => $password
        ]);

        // Then
        $response->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }

    public function testItDoesNotIssueTokenWhenGivenInvalidCredentials()
    {
        // Given
        $user = factory(User::class)->create();

        // When
        $response = $this->postJson(route('auth-token.issue'), [
            'email' => $user->email,
            'password' => 'a-random-invalid-password'
        ]);

        // Then
        $response->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    public function testItDoesNotIssueTokenWhenLoggedIn()
    {
        // Given
        $token = JWTAuth::fromUser(factory(User::class)->create());

        // When
        $response = $this->postJson(route('auth-token.issue'), [], [
            'Authorization' => 'Bearer '.$token
        ]);

        // Then
        $response->assertStatus(403);
    }
}
