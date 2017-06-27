<?php

namespace App\Http\ViewComposers;

use App\Repositories\Setting\SettingRepository;
use Illuminate\View\View;

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
