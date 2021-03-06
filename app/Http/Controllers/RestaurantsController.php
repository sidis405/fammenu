<?php

namespace App\Http\Controllers;

use App\Restaurant;

class RestaurantsController extends Controller
{
    public function show(Restaurant $restaurant, RestaurantsRepository $restaurantsRepo)
    {
        $restaurant = $restaurantsRepo->show($restaurant);

        return view('restaurants.show', compact('restaurant'));
    }
}
