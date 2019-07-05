<?php

Route::post('login', 'Api\LoginController@login')->name('login');


Route::middleware('jwt.auth')->group(function () {
    Route::get('me', 'Api\LoginController@me')->name('me');

    Route::get('home', 'Api\HomeController@index')->name('home');
    Route::get('search', 'Api\SearchController')->name('search');
    Route::get('restaurants/{restaurant}', 'Api\RestaurantsController@show')->name('restaurants.show');
    Route::post('toggle-favorites/{restaurant}', 'Api\ToggleController')->name('toggle-favorites');
});



// use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
