<?php

namespace App\Http\Controllers\Api;

use App\Restaurant;
use App\Http\Controllers\Controller;

class RestaurantsController extends Controller
{
    public function show(Restaurant $restaurant, RestaurantsRepository $restaurantsRepo)
    {
        return $restaurantsRepo->show($restaurant);
    }
}
