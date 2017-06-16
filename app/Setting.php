<?php

namespace App;

use Validator;
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

    private $errors;

    private $stripeKey = array(
        'api_key' => 'required',
    );

    private $contactEmail = array(
        'contact_email' => 'required',
    );

    private $churchName = array(
        'church_name' => 'required',
    );

    private $sliderImage = array(
        'file.*' => 'required|image',
    );

    private $churchLogo = array(
         'appLogo' => 'required|mimes:jpg,jpeg,png',
    );

    private $welcomeEmail = array(
        'welcomeEmailHeading' => 'required|string|max:40',
        'welcomeEmailBody' => 'required',
    );

    private $stripePlan = array(
        'plan_id' => 'required',
        'plan_name' => 'required',
        'plan_currency' => 'required',
        'plan_amount' => 'required|numeric',
        'plan_interval' => 'required',
        'plan_description' => 'required|max:22',
    );

    public function validate($data, $key) {
        if($key === 'stripePlan') {
            $v = Validator::make($data, $this->stripePlan);
        } elseif ($key === 'welcomeEmail') {
            $v = Validator::make($data, $this->welcomeEmail);
        } elseif ($key === 'sliderImage') {
            $v = Validator::make($data, $this->sliderImage);
        } elseif ($key === 'churchName') {
            $v = Validator::make($data, $this->churchName);
        } elseif ($key === 'contactEmail') {
            $v = Validator::make($data, $this->contactEmail);
        } elseif ($key === 'stripeKey') {
            $v = Validator::make($data, $this->stripeKey);
        } elseif ($key === 'churchLogo') {
            $v = Validator::make($data, $this->churchLogo);
        }

        if ($v->fails()) {
            $this->errors = $v->errors()->getMessages();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

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
        // we need on in gallery and one in slider
        // meaning one big and small size
        $this->addMediaConversion('gallery_size')
            ->width(250)
            ->height(150)
            ->keepOriginalImageFormat();
    }
}
