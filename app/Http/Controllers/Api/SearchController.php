<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SearchRepository;

class SearchController extends Controller
{
    protected $query;

    public function __invoke(Request $request, SearchRepository $searchRepo)
    {
        return $searchRepo->search();
    }
}
