<?php

namespace App;

use Auth;
use Validator;
use Exception;
use App\Setting;
use Carbon\Carbon;
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


    private $errors;

    private $passwordChange = array(
        'password' => 'required|min:8',
    );

    private $newUser = array(
        'name' => 'required|max:30',
        'email' => 'required|email|unique:users|max:30',
        'password' => 'required|min:8',
    );

    public function validate($data, $key) {

        if ($key === 'newUser') {
            $v = Validator::make($data, $this->newUser);
        } elseif ($key === 'passwordChange') {
            $v = Validator::make($data, $this->passwordChange);
        }

        if ($v->fails()) {
            $this->errors = $v->errors()->getMessages();;
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    protected $fillable = [
        'name', 'email', 'password', 'permission',

    ];

    protected $hidden = [
        'password', 'remember_token', 'id', 'updated_at',
        
    ];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'email'
            ]
        ];
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function favourites() {

        return $this->belongsToMany(Sermon::class, 'favourites', 'user_id', 'sermon_id')->withTimeStamps();
    }

    public function getUpdatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public static function getUserCards () {

        $stripe = new Stripe(Setting::first()->api_key);
        if( Auth::user()->customer_id === null || Auth::user()->customer_id === "") {
            return null;
        } else {
            try {
                return $stripe->cards()->all(Auth::user()->customer_id);
            } catch (Exception $e) {

            }
        }

    }


}