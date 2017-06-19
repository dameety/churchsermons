<?php

namespace App\Models;

use Carbon\Carbon;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Setting extends Model implements HasMediaConversions
{
    use Sluggable;
    use HasMediaTrait;
    use SluggableScopeHelpers;


    protected $hidden = [
        'id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function registerMediaConversions()
    {
        $this->addMediaConversion('gallery_size')
            ->width(250)
            ->height(150)
            ->keepOriginalImageFormat();
    }

    public static function createUploadsFolder()
    {
        $folder  = 'uploads/';
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), @755, true);
        }
        return public_path($folder);
    }

    public static function setStripeKey($key)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'STRIPE_KEY'   => $key
        ]);
    }

    public static function setChurchName($name)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_NAME'   => $name
        ]);
    }

    public static function setChurchEmail($name)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_EMAIL'   => $email
        ]);
    }

    public static function getNameEmailStripeKey()
    {
        $keys = collect(['stripeKey', 'name', 'email']);
        $details = $keys->combine([env('STRIPE_KEY'), env('APP_NAME'), env('APP_EMAIL')]);
        return $details;
    }
}
