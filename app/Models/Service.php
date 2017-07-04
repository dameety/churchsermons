<?php

namespace App\Models;

use Carbon\Carbon;
use App\Events\ServiceSermonCountEvent;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Service extends Model
{
    use Sluggable;
    use LogsActivity;
    use SluggableScopeHelpers;

    public function sermons()
    {
        return $this->hasMany('App\Sermon');
    }

    protected $fillable = [
        'name', 'description',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
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
        $service = self::whereId((int) ($servId))->first();
        event(new ServiceSermonCountEvent($service));
    }
}
