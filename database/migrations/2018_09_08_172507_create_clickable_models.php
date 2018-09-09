<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClickableModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metric_clicks', function (Blueprint $table) {
            $table->integer('id');
            $table->unsignedInteger('clickable_id');
            $table->string('clickable_type');
            $table->integer('clicks');
            $table->timestamp('created_at');
        });

        // Schema::create('metric_views', function(Blueprint $table) {
        //     $table->integer('id');
        //     $table->unsignedInteger('viewable_id');
        //     $table->string('viewable_type');
        //     $table->integer('views');
        //     $table->timestamp('created_at');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('metric_clicks');
        // Schema::drop('metric_views');
    }
}
