<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\DishType;
use Faker\Generator as Faker;

$factory->define(DishType::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
