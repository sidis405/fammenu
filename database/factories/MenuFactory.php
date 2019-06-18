<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'price' => $faker->randomNumber(4),
        'user_id' => factory(App\User::class),
        'restaurant_id' => factory(App\Restaurant::class),
        'start_at' => $start = $faker->dateTimeBetween($startDate = '-1 month', $endDate = '+1 month', $timezone = null),
        'end_at' => Carbon\Carbon::parse($start)->addWeeks(3),
    ];
});
