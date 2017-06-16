<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\Setting\SettingRepository;
use Intervention\Image\ImageManagerStatic as Image;

class EloquentSetting implements SettingRepository
{

    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function getAll()
    {
        return $this->setting->first();
    }

    public function getBySlug($slug)
    {
        return $this->setting->findBySlug($slug);
    }

    public function updateEmailContent($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting -> welcomeEmailHeading = $request-> welcomeEmailHeading;
        $setting -> welcomeEmailBody = $request-> welcomeEmailBody;
        $setting -> save();
        return response()->json(['status', 200]);
    }

    public function stripeKey($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting -> api_key = Crypt::encryptString($request-> api_key);
        $setting -> save();
        return response()->json(['status', 200]);
    }

    public function stripePlan($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting -> plan_id = $request->plan_id;
        $setting -> plan_name = $request->plan_name;
        $setting -> plan_amount = $request->plan_amount;
        $setting -> plan_currency = $request->plan_currency;
        $setting -> plan_interval = $request->plan_interval;
        $setting -> plan_description = $request->plan_description;
        $setting->save();
        return true;
    }

    public function contactEmail($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting -> contact_email = $request->contact_email;
        $setting -> save();
        return response()->json(['status', 200]);
    }

    public function churchName($slug, $request)
    {
        $setting = $this->getBySlug($slug);
        $setting -> church_name = $request->church_name;
        $setting -> save();
        return response()->json(['status', 200]);
    }

    public function bannerUpload($slug, $request)
    {
        $folder = $this->setting->createUploadsFolder();
        $imgFile = request()->file('file');
        foreach ($imgFile as $file) {
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            Image::make($file)
                ->resize(1080, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save(public_path($folder) . $fileName);

            $this->setting->addMedia($file)
                ->usingName(public_path($folder) . $fileName)
                ->toMediaCollection('slider_image');
        }
        return response()->json(['status', 200]);
    }

    public function delete($request)
    {
        $images = $this->setting;
        $files = $images->getMedia('slider_image');
        foreach ($files as $file) {
            $url = $file->getUrl('gallery_size');
            if ($url === $request->url) {
                $file->delete();
                return response()->json(['status', 200]);
            }
        }
    }

    public function images()
    {
        $images = $this->setting;
        $files = $images->getMedia('slider_image');

        // array to keep the urls
        $allImageUrls = array();
        foreach ($files as $file) {
            $getFileUrl = $file->getUrl('gallery_size');
            array_unshift($allImageUrls, $getFileUrl);
        }
        $sliderImages = collect($allImageUrls);
        return $sliderImages;
    }
}
