<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\{Address, Card};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    protected $card;

    public function setUp()
    {
        parent::setUp();

        $this->card = factory(Card::class)->create();
    }

    public function testItHasAddress()
    {
        $this->card->address()->save(
            factory(Address::class)->make()
        );

        $this->assertInstanceOf(Address::class, $this->card->address);
    }
}
