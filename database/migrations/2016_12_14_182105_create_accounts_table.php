<?php

use App\Model\Account;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('forename');
            $table->string('surname');
            $table->string('address')->nullable();
            $table->integer('number')->nullable();
            $table->integer('role_id')->unsigned();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('verified')->nullable();
            $table->integer('login_count')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Generate the super user account for application usage.
         */
        $account = new Account;
        $account->setEmail('Marky360@live.ie')->setPassword(bcrypt('ff0ebb5801'));
        $account->setName('Mark', 'Hester')->setRoleID(1)->setVerified(true);
        $account->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('accounts');
    }
}
