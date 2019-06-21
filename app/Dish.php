<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use CrudTrait;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($menu) {
            $menu->user_id = backpack_user()->id;
        });
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function type()
    {
        return $this->belongsTo(DishType::class, 'dish_type_id');
    }
}
