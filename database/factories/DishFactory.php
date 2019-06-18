<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Dish;
use Faker\Generator as Faker;

$factory->define(Dish::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'user_id' => factory(App\User::class),
        'restaurant_id' => factory(App\Restaurant::class),
        'dish_type_id' => factory(App\DishType::class),
        'cal' => $faker->randomNumber(3),
    ];
});
