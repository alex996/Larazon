<?php

namespace Tests\Feature\Auth;

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

    //public function testItDoesNotIssueTokenWhenLoggedIn
}
