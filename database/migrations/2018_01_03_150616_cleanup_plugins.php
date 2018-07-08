<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CleanupPlugins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('carousels');
        Schema::drop('carousel_slides');
        Schema::drop('images');
        Schema::drop('notifications');
        Schema::drop('articles');
        Schema::drop('plugin_feeds');
        Schema::drop('plugin_options');
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
