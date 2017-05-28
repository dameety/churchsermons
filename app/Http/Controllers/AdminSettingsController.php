<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Setting;



class AdminSettingsController extends Controller
{

    public function index() {
        $setting = Setting::first();
        return view('admin.settings.admin', compact('setting'));
    }

    public function sliderPage () {
        return view('admin.settings.slider');
    }

}
