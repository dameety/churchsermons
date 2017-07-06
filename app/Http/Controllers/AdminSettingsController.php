<?php

namespace App\Http\Controllers;

use App\Models\Setting;
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
        return view('admin.settings.admin', [
            'setting' => $this->setting;
        ]);
    }

    public function sliderPage()
    {
        return view('admin.settings.slider');
    }
}
