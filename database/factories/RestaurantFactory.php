<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Restaurant;
use Faker\Generator as Faker;

$factory->define(Restaurant::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\it_IT\Address($faker));

    return [
        'name' => $faker->unique()->word,
        'address' => $faker->address,
    ];
});
