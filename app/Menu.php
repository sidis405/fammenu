<?php

namespace App;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use CrudTrait;

    protected $with = ['dishes'];
    // protected $hidden = ['dishes'];
    // protected $appends = ['total_cal'];

    protected $guarded = ['id'];

    protected $dates = ['start_at', 'end_at'];

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
}
