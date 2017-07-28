<?php

use App\Model\PluginOption;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Classes\Repositories\PluginRepository;

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

        /*
         * GENERATE STATIC DATA.
         */
        $plugin = app(PluginRepository::class)->whereName('pages');

        $plugin_option = new PluginOption;
        $plugin_option->setKey('editor_height');

        $plugin->options()->save($plugin_option);

        $plugin_option = new PluginOption;
        $plugin_option->setKey('editor_width');

        $plugin->options()->save($plugin_option);
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
