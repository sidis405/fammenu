<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SearchRepository;

class SearchController extends Controller
{
    protected $query;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request, SearchRepository $searchRepo)
    {
        return $searchRepo->search();
    }
}
