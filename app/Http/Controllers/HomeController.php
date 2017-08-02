<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Sermon\SermonRepository;
use App\Repositories\Setting\SettingRepository;

class HomeController extends Controller
{

    protected $user;
    protected $sermon;
    protected $setting;

    public function __construct(SermonRepository $sermon, SettingRepository $setting, UserRepository $user)
    {
        \Debugbar::disable();
        $this->user = $user;
        $this->sermon = $sermon;
        $this->setting = $setting;
    }

    public function welcome()
    {
        return view('frontend.welcome', [
            'sermons' => $this->sermon->latestThree(),
            'sliderImages' => $this->setting->sliderImages(),
            'testimonials' => $this->setting->getTestimonials()
        ]);
    }

    public function authCheck ()
    {
        return $this->user->authCheck();
    }
}