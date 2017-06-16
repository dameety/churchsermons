<?php

namespace App\Models;

use Auth;
use Exception;
use App\Setting;
use Carbon\Carbon;
use App\Models\Sermon;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Sluggable;
    use Notifiable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'name', 'email', 'password', 'permission',

    ];

    protected $hidden = [
        'password', 'remember_token', 'id', 'updated_at',

    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'email'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function favourites()
    {
        return $this->belongsToMany(Sermon::class, 'favourites', 'user_id', 'sermon_id')->withTimeStamps();
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public static function getUserCards()
    {
        $stripe = new Stripe(Setting::first()->api_key);
        if (Auth::user()->customer_id === null || Auth::user()->customer_id === "") {
            return null;
        } else {
            try {
                return $stripe->cards()->all(Auth::user()->customer_id);
            } catch (Exception $e) {
            }
        }
    }

    public static function checkPersmision($status)
    {
        if (Auth::user()->permission === Setting::first()->plan_name) {
            return true;
        } elseif (Auth::user()->permission !== $setting->plan_name && $status === "free") {
            return true;
        } else {
            return false;
        }
    }
}
