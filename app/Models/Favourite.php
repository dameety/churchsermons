<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
        'title', 'preacher', 'sermon_id', 'user_id', 'datepreached', 'status', 'filename', 'path', 'slug',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
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

    public function getdatepreachedAttribute($value)
    {
        return Carbon::parse($value)->format('d F Y');
    }
}
