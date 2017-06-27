<?php

namespace App\Listeners;

use App\Events\CategorySermonCountEvent;

class CategorySermonCountEventListener
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
     * @param CategorySermonCountEvent $event
     *
     * @return void
     */
    public function handle(CategorySermonCountEvent $event)
    {
        //
        $currentCategory = $event->category;

        $previousCategorySermonCount = $currentCategory->sermonCount;

        $currentCategory->sermonCount = $previousCategorySermonCount + 1;

        $currentCategory->save();
    }
}
