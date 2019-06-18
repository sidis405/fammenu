<?php

Route::get('test', function () {
    return App\Menu::first();
});

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    // Route::get('dashboard', '\MS\Http\Controllers\Admin\AdminController@dashboard');
    CRUD::resource('restaurants', 'Admin\RestaurantCrudControllerCrudController');
    CRUD::resource('menus', 'Admin\MenuCrudControllerCrudController');
    CRUD::resource('dishes', 'Admin\DishCrudControllerCrudController');
});
