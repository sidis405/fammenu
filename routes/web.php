<?php

Route::view('/', 'welcome');

Route::prefix('admin')->group(function () {
    // Route::get('dashboard', '\MS\Http\Controllers\Admin\AdminController@dashboard');
    CRUD::resource('restaurants', 'Admin\RestaurantCrudControllerCrudController');
    CRUD::resource('menus', 'Admin\MenuCrudControllerCrudController');
    CRUD::resource('dishes', 'Admin\DishCrudControllerCrudController');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('search', 'SearchController')->name('search');
Route::get('restaurants/{restaurant}', 'RestaurantsController@show')->name('restaurants.show');
Route::post('toggle-favorites/{restaurant}', 'ToggleController')->name('toggle-favorites');
