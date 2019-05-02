<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_access_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->ipAddress('ip_address');
            $table->string('message');
            $table->timestamps();
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('ip_address');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('login_count');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->string('surname')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backend_access_log');
    }
}
