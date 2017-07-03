<?php

namespace App\Models;

use App\Events\ServiceSermonCountEvent;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

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
