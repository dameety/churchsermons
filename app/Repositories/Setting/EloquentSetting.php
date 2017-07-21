<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use App\Models\Testimonial;
use Intervention\Image\ImageManagerStatic as Image;

class EloquentSetting implements SettingRepository
{
    private $setting;
    private $testimonial;

    public function __construct(Setting $setting, Testimonial $testimonial)
    {
        $this->setting = $setting;
        $this->testimonial = $testimonial;
    }

    public function getAll()
    {
        return $this->setting->first();
    }

    public function getTestimonials()
    {
        return $this->testimonial->all();
    }

    public function getBySlug($slug)
    {
        return $this->setting->findBySlug($slug);
    }

    public function emailContent($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting->welcomeEmailHeading = $request->welcomeEmailHeading;
        $setting->welcomeEmailBody = $request->welcomeEmailBody;
        $setting->save();

        return response()->json(['status', 200]);
    }

    public function stripeKey($request)
    {
        $this->setting->setStripeKey($request->api_key);

        return response()->json(['status', 200]);
    }

    public function getStripeKey()
    {
        $key = env('STRIPE_KEY');
        return $key;
    }

    public function stripePlan($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting->plan_id = $request->plan_id;
        $setting->plan_name = $request->plan_name;
        $setting->plan_amount = $request->plan_amount;
        $setting->plan_currency = $request->plan_currency;
        $setting->plan_interval = $request->plan_interval;
        $setting->save();

        return true;
    }

    public function contactEmail($request)
    {
        $this->setting->setChurchName($request->contactEmail);

        return response()->json(['status', 200]);
    }

    public function churchName($request)
    {
        $this->setting->setChurchName($request->churchName);

        return response()->json(['status', 200]);
    }

    public function getDetails()
    {
        return $this->setting->getNameEmailStripeKey();
    }

    public function sliderIsLessThan5()
    {
        $images = $this->setting->first()->getMedia('slider_image')->count();
        if ($images < 5) {
            return true;
        } else {
            return false;
        }
    }

    public function bannerUpload($request)
    {
        $folder = $this->setting->createUploadsFolder();
        $imgFile = request()->file('file');
        foreach ($imgFile as $file) {
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            Image::make($file)
                ->resize(1080, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($folder.$fileName);
            $this->setting->first()->addMedia($file)
                ->usingName(public_path($folder).$fileName)
                ->toMediaCollection('slider_image');
        }

        return response()->json(['status', 200]);
    }

    public function delete($request)
    {
        $images = $this->setting->first();
        $files = $images->getMedia('slider_image');
        foreach ($files as $file) {
            $url = $file->getUrl('gallery_size');
            if ($url === $request->url) {
                $file->delete();

                return response()->json(['status', 200]);
            }
        }
    }

    public function sliderImages()
    {
        $images = $this->setting->first();
        if($images) {        
            $sliderImages = $images->getMedia('slider_image');
            // array to keep the urls
            $allImageUrls = [];
            foreach ($sliderImages as $file) {
                $getFileUrl = $file->getUrl('gallery_size');
                array_unshift($allImageUrls, $getFileUrl);
            }

            return $allImageUrls;
        } else {
            //
        }
    }
}
