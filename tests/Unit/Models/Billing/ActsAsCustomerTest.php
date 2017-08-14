<?php

namespace Tests\Unit\Models\Billing;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActsAsCustomerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testItCreatesStripeCustomerAndSavesCardDetails()
    {
        // Given
        $token = $this->getStripeToken();
        // When
        $customer = $this->user->createCustomerWithCard($token->id);
        $user = $this->user->fresh();
        // Then
        $this->assertNotEmpty($customer);
        $this->assertEquals($user->stripe_id, $customer->id);

        $this->assertNotEmpty($card = array_first($customer->sources->data));
        $this->assertEquals($card->id, $token->card->id);
    }
}
