<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $guarded = ['id'];

    use CrudTrait;

    public function hosts()
    {
        return $this->belongsToMany(User::class, 'restaurant_user', 'restaurant_id', 'user_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
