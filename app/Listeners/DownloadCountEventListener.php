<?php

namespace App\Listeners;

use App\Events\DownloadCountEvent;
use Illuminate\Support\Facades\Auth;

class DownloadCountEventListener
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
     * @param DownloadCountEvent $event
     *
     * @return void
     */
    public function handle(DownloadCountEvent $event)
    {

        // update the user download count
        $user = Auth::user();
        $previousUserDownloadCount = $user->downloadCount;
        $user->downloadCount = $previousUserDownloadCount + 1;
        $user->save();

        // update the sermon download count
        $currentSermon = $event->sermon;
        $previousDownloadCount = $currentSermon->downloadCount;
        $currentSermon->downloadCount = $previousDownloadCount + 1;
        $currentSermon->save();
    }
}
