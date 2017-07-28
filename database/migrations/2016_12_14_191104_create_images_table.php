<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename')->unique();
            $table->string('extension');
            $table->string('directory');
            $table->integer('size');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('published')->nullable();
            $table->unsignedInteger('uploader_id');
            $table->unsignedInteger('modifier_id')->nullable();
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
        \Schema::dropIfExists('images');
    }
}
