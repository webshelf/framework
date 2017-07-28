<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->unsignedInteger('category');
            $table->tinyInteger('publish');
            $table->timestamp('publish_date')->nullable();
            $table->timestamp('unpublish_date')->nullable();
            $table->timestamp('event_date')->nullable();
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('modified_id');
            $table->string('alt_text');
            $table->string('seo_title');
            $table->string('seo_keywords');
            $table->string('seo_description');
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
        \Schema::dropIfExists('news');
    }
}
