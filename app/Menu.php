<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Menu extends Model
{
    use CrudTrait;

    protected $with = ['dishes', 'restaurant'];
    // protected $hidden = ['dishes'];
    // protected $appends = ['total_cal'];
    protected $appends = ['link'];

    protected $guarded = ['id'];

    protected $dates = ['start_at', 'end_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($menu) {
            $menu->user_id = backpack_user()->id;
        });
    }

    public function scopeFromFavorites(Builder $query)
    {
        return $query->whereIn('restaurant_id', auth()->user()->favorites->pluck('id')->toArray());
    }

    public function scopeValid(Builder $query)
    {
        return $query->where('start_at', '<=', now())->where('end_at', '>', now());
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }

    // Accessors
    // Pippo
    // getPippoAttribute
    // public function getTotalCalAttribute()
    // {
    //     return $this->dishes->pluck('cal')->sum();
    // }

    public function updateCal()
    {
        $this->update([
          'cal' => $this->fresh()->dishes->pluck('cal')->sum()
        ]);
    }

    public function getLinkAttribute()
    {
        return route('restaurants.show', $this->restaurant);
    }
}
