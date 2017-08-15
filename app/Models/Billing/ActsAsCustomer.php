<?php

namespace App\Models\Billing;

use Stripe\Customer;

trait ActsAsCustomer
{
    public function hasStripeId()
    {
        return !! $this->stripe_id;
    }

    public function createCustomerWithCard(string $token)
    {
        $customer = Customer::create([
            'email' => $this->email,
            'source' => $token,
        ]);

        $this->stripe_id = $customer->id;
        $this->save();

        $this->addCard(
            array_first($customer->sources->data)
        );

        return $customer;
    }

    public function updateCustomerWithCard(string $token)
    {
        $customer = $this->asStripeCustomer();

        $card = $customer->sources->create([
            'source' => $token,
            'expand' => ['customer']
        ]);

        $this->addCard($card);

        return $card->customer;
    }

    public function asStripeCustomer()
    {
        return Customer::retrieve($this->stripe_id);
    }
}