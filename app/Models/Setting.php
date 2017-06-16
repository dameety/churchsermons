<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
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

    public function sgetApiKeyAttribute($value)
    {
        return Crypt::decryptString($value);
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
}
