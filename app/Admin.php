<?php

namespace App;


use Auth;
use Carbon\Carbon;
use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Validator;

class Admin extends Authenticatable
{

    use Notifiable;
    use Sluggable;
    use SluggableScopeHelpers;

    private $errors;

    //rule for password change
    private $passwordChange = array(
        'password' => 'required|min:8',
    );

    //rule for new user
    private $newAdmin = array(
        'name' => 'required|max:30',
        'email' => 'required|email|unique:users|max:30',
        'password' => 'required|min:8',
    );

    public function validate($data, $key)
    {
        if ($key === 'newAdmin') {
            $v = Validator::make($data, $this->newAdmin);
        } elseif ($key === 'passwordChange') {
            $v = Validator::make($data, $this->passwordChange);
        }

        if ($v->fails()) {
            $this->errors = $v->errors()->getMessages();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected $fillable = [
        'name', 'email', 'password',
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
        $admin = Auth::guard('admin')->user();
        if ($admin->permission !== 'Super Admin') {
            return false;
        }
        return true;
    }
}
