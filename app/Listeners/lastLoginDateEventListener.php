<?php

namespace App\Listeners;

use App\Events\lastLoginDateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;


class lastLoginDateEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  lastLoginDateEvent  $event
     * @return void
     */
    public function handle(lastLoginDateEvent $event)
    {
        // get current date and time
        $now = Carbon::now();

        // get user
        $currentUser = $event->user;
        
        // save last login date
        $currentUser -> lastLoginDate = $now;
        $currentUser->save();

    }
}
