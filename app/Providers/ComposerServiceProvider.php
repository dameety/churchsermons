<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer(
            [
                'admin.sermons.newsermon',
                'admin.sermons.edit'
            ],
            'App\Http\ViewComposers\ServiceComposer'
        );

        View::composer(
            [
                'admin.sermons.newsermon',
                'admin.sermons.edit'
            ],
            'App\Http\ViewComposers\CategoryComposer'
        );

        View::composer(
            [
                'frontend.partials.filters-desktop',
                'frontend.partials.filters'
            ],
            'App\Http\ViewComposers\CategoryComposer@filter'
        );

        View::composer(
            [
                'frontend.partials.filters-desktop',
                'frontend.partials.filters'
            ],
            'App\Http\ViewComposers\ServiceComposer@filter'
        );

        View::composer('emails.welcome-user', 'App\Http\ViewComposers\SettingsComposer@emailContent');
    }


    public function register()
    {
        //
    }
}
