<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Sermon\SermonRepository;
use App\Repositories\Setting\SettingRepository;

class HomeController extends Controller
{

    protected $sermon;
    protected $setting;

    public function __construct(SermonRepository $sermon, SettingRepository $setting)
    {
        $this->sermon = $sermon;
        $this->setting = $setting;
    }

    public function welcome()
    {
        \Debugbar::disable();

        return view('frontend.welcome', [
            'sermons' => $this->sermon->latestThree(),
            'sliderImages' => $this->setting->sliderImages(),
            'testimonials' => $this->setting->getTestimonials()
        ]);

    }
}
