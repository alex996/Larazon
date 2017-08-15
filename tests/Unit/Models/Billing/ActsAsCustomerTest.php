<?php

namespace Tests\Unit\Models\Billing;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActsAsCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesStripeCustomerAndSavesCardDetails()
    {
        // Given
        $user = factory(User::class)->create();
        $token = $this->getStripeToken();
        // When
        $customer = $user->createCustomerWithCard($token->id);
        $user = $user->fresh();
        // Then
        $this->assertNotEmpty($customer);
        $this->assertEquals($user->stripe_id, $customer->id);

        $this->assertNotEmpty($card = array_first($customer->sources->data));
        $this->assertEquals($card->id, $token->card->id);
    }

    public function testItUpdatesCustomerByAddingNewCard()
    {
        // Given
        $user = factory(User::class)->create();
        $user->createCustomerWithCard(
            $this->getVisaToken()->id
        );
        $token = $this->getMasterCardToken();
        // When
        $user = $user->fresh();
        $customer = $user->updateCustomerWithCard($token->id);
        // Then
        $this->assertNotEmpty($customer);
        $this->assertCount(2, $cards = $customer->sources->data);

        $this->assertNotEmpty($card = array_last($cards));
        $this->assertEquals($card->id, $token->card->id);
    }
}
