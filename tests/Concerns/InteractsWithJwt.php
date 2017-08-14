<?php

namespace Tests\Concerns;

use JWTAuth;
use App\Models\User;

trait InteractsWithJwt
{
    public function getJwtToken($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        return JWTAuth::fromUser($user);
    }
}