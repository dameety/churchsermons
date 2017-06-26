<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPassword;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{

    use Sluggable;
    use Notifiable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'name', 'email', 'password', 'permission'
    ];

    protected $hidden = [
        'password', 'remember_token', 'id', 'updated_at'

    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

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

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public static function adminPermission()
    {
        if (Auth::guard()->user()->permission !== 'Super Admin') {
            return false;
        }
        return true;
    }

    public static function current()
    {
        return Auth::guard()->user();
    }
}
