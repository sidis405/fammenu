<?php

namespace App\Http\Controllers;

use App\Restaurant;

class RestaurantsController extends Controller
{
    public function show(Restaurant $restaurant)
    {
        $restaurant->load('validmenus.dishes.type', 'validmenus.restaurant');

        return view('restaurants.show', compact('restaurant'));
    }
}
