<?php

namespace App\Http\Controllers;

use App\Repositories\MenuRepository;

class HomeController extends Controller
{
    protected $menusRepo;

    public function __construct(MenuRepository $menusRepo)
    {
        $this->middleware('auth');
        $this->menusRepo = $menusRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = $this->menusRepo->getUserFavorites();

        return view('home', compact('menus'));
    }
}
