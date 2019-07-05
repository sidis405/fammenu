<?php

namespace App\Repositories;

use App\Menu;
use App\Restaurant;

class SearchRepository
{
    protected $query;

    public function search()
    {
        $this->query = $request->get('query');

        if (strlen($this->query) < 3) {
            return [];
        }

        return [
            'restaurants' => $this->getRestaurants(),
            'menus' => $this->getMenus(),
        ];
    }

    protected function getRestaurants()
    {
        return Restaurant::where('name', 'LIKE', '%' . $this->query . '%')->get();
    }

    protected function getMenus()
    {
        return Menu::whereHas('dishes', function ($query) {
            $query->where('name', 'LIKE', '%' . $this->query . '%');
        })->get();
    }
}
