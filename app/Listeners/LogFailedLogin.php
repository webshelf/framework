<?php

namespace App\Listeners;

use App\Model\AccessLog;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
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
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        AccessLog::generateLog($event->credentials['email'], request()->getClientIp(), AccessLog::LOGIN_STATUS_FAILED);
    }
}
