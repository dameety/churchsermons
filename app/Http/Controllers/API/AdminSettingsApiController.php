<?php

namespace App\Http\Controllers\API;

use DB;
use File;
use App\Setting;
use App\Http\Requests;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\ImageManagerStatic as Image;


class AdminSettingsApiController extends Controller
{

    private $setting;

    public function __construct () {
        $this->setting = Setting::first();
    }

    public function index () {
        return $this->setting;
    }

    public function appLogo (Request $request) {
        $data = Input::all();        
        if($this->setting->validate($data, 'churchLogo')) {

  
            return response('success', 200);  
        } else {
            return response($setting->getErrors(), 422);
        }

    }

    public function updateWelcomeEmail (Request $request, $slug) {
        $data = Input::all();
        $setting = Setting::whereSlug($slug)->first();

        if($setting->validate($data, 'welcomeEmail')) {
            $setting -> welcomeEmailHeading = $request-> welcomeEmailHeading;
            $setting -> welcomeEmailBody = $request-> welcomeEmailBody;
            $setting -> save();     
            return response('success', 200);  
        } else {
            return response($setting->getErrors(), 422);
        }

    }

    public function saveStripeKey(Request $request, $slug) {
        $data = Input::all();
        $setting = Setting::whereSlug($slug)->first();

        if($setting->validate($data, 'stripeKey')) {
            $encryptedKey = Crypt::encryptString($request-> api_key);
            $setting -> api_key = $encryptedKey;
            $setting -> save();     
            return response('success', 200);  
        } else {
            return response($setting->getErrors(), 422);
        }

    }

    public function saveStripePlan (Request $request, $slug) {
        $data = Input::all();
        $setting = Setting::whereSlug($slug)->first();

        if($setting->validate($data, 'stripePlan')) {
            $stripe = new Stripe($setting->api_key);
            $setting -> plan_id = $request->plan_id;
            $setting -> plan_name = $request->plan_name;
            $setting -> plan_amount = $request->plan_amount;
            $setting -> plan_currency = $request->plan_currency;
            $setting -> plan_interval = $request->plan_interval;
            $setting -> plan_description = $request->plan_description;

            // save to stripe
            $plan = $stripe->plans()->create([
                'id'                   => $request->plan_id,
                'name'                 => $request->plan_name,
                'amount'               => $request->plan_amount,
                'currency'             => $request->plan_currency,
                'interval'             => $request->plan_interval,
                'statement_descriptor' => $request->plan_description,
            ]);

            $setting -> save();
            return response('success', 200);

        } else {
            return response($setting->getErrors(), 422);
        }

    }

    public function saveContactEmail (Request $request, $slug) {
        $data = Input::all();
        $setting = Setting::whereSlug($slug)->first();

        if($setting->validate($data, 'contactEmail')) {
            $setting -> contact_email = $request->contact_email;
            $setting -> save();
            return response('success', 200);  
        } else {
            return response($setting->getErrors(), 422);
        }

    }


    public function saveChurchName (Request $request, $slug) {
        $data = Input::all();
        $setting = Setting::whereSlug($slug)->first();

        if($setting->validate($data, 'churchName')) {
            $setting -> church_name = $request->church_name;
            $setting -> save();
            return response('success', 200);  
        } else {
            return response($setting->getErrors(), 422);
        }

    }
  

    public function sliderImageUpload (Request $request) {
        $data = Input::all();

        if($this->setting->validate($data, 'sliderImage')) {
            $homeImages = $this->setting->getMedia('slider_image')->count();
            if( $homeImages < 5 ) {

                $imgFile = request()->file('file');
                foreach ($imgFile as $file) {

                    $folder  = 'uploads/';
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                    if(!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), @755, true);
                    }

                    Image::make($file)
                        ->resize(1080, null, function($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->save(public_path($folder) . $fileName);

                    $this->setting->addMedia($file)
                        ->usingName(public_path($folder) . $fileName)
                        ->toMediaCollection('slider_image');

                    return response('success', 200);

                }
                
            } else {
                return response('The slider can take only 5 images', 422);
            }

        } else {
            return response($setting->getErrors(), 422);
        }

    }

    public function deleteSliderImage (Request $request) {
        $images = $this->setting;
        $files = $images->getMedia('slider_image');
        foreach($files as $file) {

            $url = $file->getUrl('gallery_size');
            if( $url === $request->url ) {
                $file->delete();
                return response('success', 200);
            }

        }

    }
    

    public function getSliderImages () {
        $images = $this->setting;
        $files = $images->getMedia('slider_image');

        // array to keep the urls
        $allImageUrls = array();
        foreach($files as $file) {

            $getFileUrl = $file->getUrl('gallery_size');
            array_unshift($allImageUrls , $getFileUrl);
                
        }
        $sliderImages = collect($allImageUrls);
        return $sliderImages;

    }


}
