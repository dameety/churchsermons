<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        
        'App\Events\lastLoginDateEvent' => [
            'App\Listeners\lastLoginDateEventListener',
        ],

        'App\Events\CategorySermonCountEvent' => [
            'App\Listeners\CategorySermonCountEventListener',
        ],

        'App\Events\ServiceSermonCountEvent' => [
            'App\Listeners\ServiceSermonCountEventListener',
        ],

        'App\Events\DownloadCountEvent' => [
            'App\Listeners\DownloadCountEventListener',
        ],

        'App\Events\LastDownloadTimeEvent' => [
            'App\Listeners\LastDownloadTimeEventListener',
        ],

        'App\Events\LastDownloadByEvent' => [
            'App\Listeners\LastDownloadByEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
