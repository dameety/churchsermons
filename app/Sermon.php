<?php

namespace App;


use Validator;
use App\Service;
use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Intervention\Image\ImageManagerStatic as Image;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;


class Sermon extends Model implements HasMedia
{
    use Sluggable;
    use HasMediaTrait;
    use SluggableScopeHelpers;

    private $errors;

    private $rules = array(
        'title' => 'required|max:40',
        'preacher' => 'required|max:30',
        'sermonImage' => 'file|image',
    );

    public function validate($data) {
        $v = Validator::make($data, $this->rules);
        if ($v->fails()) {
            $this->errors = $v->errors()->getMessages();;
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function category () {
        return $this->belongsTo('App\Category');
    }

    public function service () {
        return $this->belongsTo('App\Service');
    }

    protected $fillable = [
    	'title', 'preacher', 'service_id', 'category_id', 'datepreached', 'status', 'filename', 'size', 'type', 'imageurl', 'slug',
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getUpdatedAtAttribute($value) {
    	return Carbon::parse($value)->format('d-m-Y');
	}

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }

	public function getdatepreachedAttribute($value) {
	    return Carbon::parse($value)->format('d F Y');
	}

    public static function saveSermonImage ( $request ) {

        $sermonImage = request()->file('sermonImage');
        $folder  = 'uploads/';
        $fileName = uniqid() . '.' . $sermonImage->getClientOriginalExtension();
        
        if(!file_exists(public_path($folder))) {
            mkdir(public_path($folder), @755, true);
        }

        $savedFile = Image::make($sermonImage)
            ->resize(400, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path($folder) . $fileName);
        return public_path($folder) . $fileName;

    }

    public function removeMediaFromSermon () {
        $image = $this->getMedia();
        $image[0]->delete();
    }

    public function addMediaToSermon( $path ) {
        $this->addMedia( $path )->toMediaCollection('sermon_image');
    }

    public static function addImageUrlToSermon () {
        $sermon = Sermon::findBySlug($slug);
        if($sermon->imageurl === null) {
            $image = $sermon->getMedia('sermon_image');
            $sermon->imageurl = $image[0]->getUrl();
            $sermon->save();
            return true;
        } else {
            return;
        }

    }

    public static function addImageUrlToUpdatedSermon () {

        $sermon = Sermon::latest('updated_at')->get()->first();
        $image = $sermon->getMedia('sermon_image');
        $sermon->imageurl = $image[0]->getUrl();
        $sermon->save();
        return true;

    }

    public static function sermonCategoryFilters () {
        return Category::latest('created_at')->get();
    }

    public static function sermonServiceFilters () {
        return Service::latest('created_at')->get();
    }

}
