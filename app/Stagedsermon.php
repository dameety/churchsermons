<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;


class Stagedsermon extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = [
    	'title', 'path', 'size', 'type',
    ];


    protected $hidden = [
        'created_at', 'updated_at', 'id', 'updated_at',
        
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }



}
