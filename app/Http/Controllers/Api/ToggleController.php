<?php

namespace App\Http\Controllers\Api;

use App\Restaurant;
use App\Http\Controllers\Controller;

class ToggleController extends Controller
{
    public function __invoke(Restaurant $restaurant, MenuRepository $menuRepo)
    {
        return $menuRepo->toggleForUser($restaurant);
    }
}
