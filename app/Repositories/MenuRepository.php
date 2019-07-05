<?php

namespace App\Repositories;

use App\Menu;
use App\Restaurant;

class MenuRepository
{
    public function getUserFavorites()
    {
        return Menu::with('restaurant', 'dishes.type')->fromFavorites()->valid()->get();
    }

    public function toggleForUser(Restaurant $restaurant)
    {
        return count(auth()->user()->favorites()->toggle($restaurant->id)['attached']);
    }
}
