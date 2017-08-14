<?php

use App\Models\{Card, User};
use Faker\Generator as Faker;

$factory->define(Card::class, function (Faker $faker) {
    return [
        'stripe_id' => str_random(29),
        'user_id' => factory(User::class)->create()->id,
        'brand' => $faker->creditCardType,
        'last4' => $faker->randomNumber(4),
        'country' => 'US',
        'exp_month' => $faker->numberBetween(1, 12),
        'exp_year' => date('Y') + $faker->randomDigitNotNull,
    ];
});
