<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id')->nullable();
            $table->integer('level')->nullable();
            $table->string('message');
            $table->timestamp('read_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('notifications');
    }
}
