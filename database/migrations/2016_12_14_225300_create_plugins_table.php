<?php

use App\Model\Plugin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('plugins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('version');
            $table->string('icon');
            $table->tinyInteger('enabled')->nullable();
            $table->tinyInteger('installed')->nullable();
            $table->tinyInteger('hidden')->nullable();
            $table->tinyInteger('required')->nullable();
            $table->tinyInteger('is_frontend')->nullable();
            $table->tinyInteger('is_backend')->nullable();
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
        \Schema::dropIfExists('plugins');
    }
}
