<?php

namespace App\Listeners;

use App\Events\LastDownloadByEvent;
use Illuminate\Support\Facades\Auth;

class LastDownloadByEventListener
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
     * @param LastDownloadByEvent $event
     *
     * @return void
     */
    public function handle(LastDownloadByEvent $event)
    {
        $currentSermon = $event->sermon;
        $currentSermonName = $currentSermon->title;
        // get current authenticated use
        $user = Auth::user();
        $user->lastSermonDownloaded = $currentSermonName;
        $user->save();

        // save username to sermon
        $userName = Auth::user()->name;
        $currentSermon->lastDownloadBy = $userName;
        $currentSermon->save();
    }
}
