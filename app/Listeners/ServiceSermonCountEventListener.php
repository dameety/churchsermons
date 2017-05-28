<?php

namespace App\Listeners;

use App\Events\ServiceSermonCountEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ServiceSermonCountEventListener
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
     * @param  ServiceSermonCountEvent  $event
     * @return void
     */
    public function handle(ServiceSermonCountEvent $event)
    {
        $currentService = $event->service;
        
        $previousServiceSermonCount = $currentService->sermonCount;
        
        $currentService->sermonCount = $previousServiceSermonCount + 1;

        $currentService->save();
    }
}
