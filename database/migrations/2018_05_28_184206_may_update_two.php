<?php

use App\Model\Account;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class MayUpdateTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('audits');

        // Create a new standard account for new tables.
        $account = Account::find(1);

        if (! $account) {
            $account = new Account;
            $account->setAttribute('forename', 'Root');
            $account->setAttribute('surname', 'Account');
            $account->setAttribute('email', 'webshelf@live.ie');
            $account->setAttribute('verified', true);
            $account->setAttribute('status', true);
            $account->setAttribute('role_id', true);
            $account->setAttribute('password', bcrypt('password'));
            $account->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
