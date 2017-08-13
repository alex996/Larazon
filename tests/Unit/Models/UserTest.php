<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\{Address, User};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testItHasAddresses()
    {
        $this->user->addresses()->saveMany(
            factory(Address::class, 5)->make()
        );

        $this->assertInstanceOf(Collection::class, $this->user->addresses);

        $this->assertInstanceOf(Address::class, $this->user->addresses->first());
    }
}
