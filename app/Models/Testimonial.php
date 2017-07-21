<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Testimonial extends Model
{
    use Sluggable;
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
                'source' => 'subject',
            ],
        ];
    }
}
