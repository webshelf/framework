<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Model\AccessLog;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // store last login.
        $event->user->fill(['last_login' => Carbon::now()])->save();

        // log the access.
        AccessLog::generateLog($event->user->email, request()->getClientIp(), AccessLog::LOGIN_STATUS_SUCCESS);
    }
}
