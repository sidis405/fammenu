<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Restaurant;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $query;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
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

    private function getRestaurants()
    {
        return Restaurant::where('name', 'LIKE', '%' . $this->query . '%')->get();
    }

    private function getMenus()
    {
        return Menu::whereHas('dishes', function ($query) {
            $query->where('name', 'LIKE', '%' . $this->query . '%');
        })->get();
    }
}
