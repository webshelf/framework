<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('plugin_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plugin_id');
            $table->string('key');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->unique(['key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('plugin_options');
    }
}
