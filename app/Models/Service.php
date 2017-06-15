<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Events\ServiceSermonCountEvent;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Service extends Model
{

    use Sluggable;
    use SluggableScopeHelpers;

    public function sermons()
    {
        return $this-> hasMany('App\Sermon');
    }

    protected $fillable = [
        'name', 'description',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public static function countUp($servId)
    {
        $service = Service::whereId((int)($servId))->first();
        event(new ServiceSermonCountEvent($service));
    }
}
