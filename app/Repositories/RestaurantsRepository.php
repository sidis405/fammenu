<?php

namespace App\Repositories;

use App\Restaurant;

class RestaurantsRepository
{
    public function show(Restaurant $restaurant)
    {
        return $restaurant->load('validmenus.dishes.type', 'validmenus.restaurant');
    }
}
