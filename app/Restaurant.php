<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['link', 'isFavorited'];

    use CrudTrait;

    public function hosts()
    {
        return $this->belongsToMany(User::class, 'restaurant_user', 'restaurant_id', 'user_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function validmenus()
    {
        return $this->hasMany(Menu::class)->where('start_at', '<=', now())->where('end_at', '>', now());
        ;
    }

    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

    public function getLinkAttribute()
    {
        return route('restaurants.show', $this);
    }

    public function getIsFavoritedAttribute()
    {
        return ! ! auth()->user()->favorites->contains($this);
    }
}
