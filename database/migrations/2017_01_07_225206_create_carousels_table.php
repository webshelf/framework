<?php

use App\Model\Plugin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Classes\Repositories\PluginRepository;

class CreateCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('carousels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('style');
            $table->boolean('lock');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('editor_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        \Schema::create('carousel_slides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->unsignedInteger('carousel_id');
            $table->unsignedInteger('image_id')->nullable();
            $table->string('link_url');
            $table->string('link_target');
            $table->integer('order_id');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('editor_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        /** @var Plugin $plugin */
        $plugin = new Plugin();
        $plugin->setName('carousels');
        $plugin->setVersion('1.0');
        $plugin->setIcon('fa-fast-forward');
        $plugin->setBackEnd(true);
        $plugin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::drop('carousels');

        \Schema::drop('carousel_slides');

        app(PluginRepository::class)->whereName('carousels')->delete();
    }
}
