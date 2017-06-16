<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Repositories\Setting\SettingRepository;

class AdminSettingsController extends Controller
{

    protected $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        $setting = $this->setting;
        return view('admin.settings.admin', compact('setting'));
    }

    public function sliderPage()
    {
        return view('admin.settings.slider');
    }
}
