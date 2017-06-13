<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // $settings= \App\Setting::first();
        // View::share('setting', $settings);

        //composers for the filter
        view()->composer('frontend.partials.filters-desktop', function ($view) {
            $view->with('services', \App\Sermon::sermonServiceFilters());
        });
        view()->composer('frontend.partials.filters-desktop', function ($view) {
            $view->with('categories', \App\Sermon::sermonCategoryFilters());
        });
        view()->composer('frontend.partials.filters', function ($view) {
            $view->with('services', \App\Sermon::sermonServiceFilters());
        });
        view()->composer('frontend.partials.filters', function ($view) {
            $view->with('categories', \App\Sermon::sermonCategoryFilters());
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Hesto\MultiAuth\MultiAuthServiceProvider');
        }
    }
}
