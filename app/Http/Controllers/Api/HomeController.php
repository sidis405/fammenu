<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;

class HomeController extends Controller
{
    protected $menusRepo;

    public function __construct(MenuRepository $menusRepo)
    {
        $this->menusRepo = $menusRepo;
    }

    public function index()
    {
        return $this->menusRepo->getUserFavorites();
    }
}
