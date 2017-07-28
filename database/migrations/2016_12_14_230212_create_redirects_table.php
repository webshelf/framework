<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('modifier_id');
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
        \Schema::dropIfExists('redirects');
    }
}
