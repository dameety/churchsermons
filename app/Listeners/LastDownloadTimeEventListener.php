<?php

namespace App\Listeners;

use App\Events\LastDownloadTimeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;


class LastDownloadTimeEventListener
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
     * @param  LastDownloadTimeEvent  $event
     * @return void
     */
    public function handle(LastDownloadTimeEvent $event)
    {
        // get current date and time
        $now = Carbon::now();

        // get sermon
        $sermon = $event ->sermon;

        // save last download date
        $sermon ->lastDownloadTime = $now;
        $sermon->save();
    }
}
