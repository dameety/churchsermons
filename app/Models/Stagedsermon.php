<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

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
