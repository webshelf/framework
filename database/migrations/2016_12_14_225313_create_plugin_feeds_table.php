<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('plugin_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plugin_id');
            $table->integer('size');
            $table->unsignedInteger('page_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('plugin_feeds');
    }
}
