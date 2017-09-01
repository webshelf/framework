<?php

namespace App\Listeners;

use App\Events\PageWasVisited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementPageView implements ShouldQueue
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
     * @param  PageWasVisited  $event
     * @return void
     */
    public function handle(PageWasVisited $event)
    {
        $event->page->incrementViews();

        $event->page->save();
    }
}
