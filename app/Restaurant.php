<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
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
