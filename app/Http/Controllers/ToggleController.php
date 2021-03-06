<?php

namespace App\Http\Controllers;

use App\Restaurant;

class ToggleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Restaurant $restaurant, MenuRepository $menuRepo)
    {
        return $menuRepo->toggleForUser($restaurant);
    }
}
