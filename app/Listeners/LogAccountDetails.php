<?php

namespace App\Listeners;

use App\Events\AccountAccessed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class LogAccountDetails
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
     * @param  AccountAccessed  $event
     * @return void
     */
    public function handle(AccountAccessed $event)
    {
        $account = $event->account;

        $account->increment('login_count');

        $account->setAttribute('last_login', Carbon::now());

        $account->setAttribute('ip_address', request()->getClientIp());

        $account->save();
    }
}
