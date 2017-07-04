<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Stagedsermon extends Model
{
    use Sluggable;
    use LogsActivity;
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
                'source' => 'title',
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
