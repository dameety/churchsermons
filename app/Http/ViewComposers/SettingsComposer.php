<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Setting\SettingRepository;

class SettingsComposer
{

    protected $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function emailContent(View $view)
    {
        $view->with('settings', $this->setting->getAll());
    }
}
