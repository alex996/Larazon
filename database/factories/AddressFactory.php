<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Address::class, function (Faker $faker) {
    return [
        'line_1' => $faker->buildingNumber . ' '. $faker->streetName,
        'line_2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'country' => 'US',
        'zip' => (string) $faker->randomNumber(5),
    ];
});
