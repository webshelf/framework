<?php

use App\Model\Plugin;
use Illuminate\Database\Migrations\Migration;
use App\Classes\Repositories\PluginRepository;

class EditFacebookPluginData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var Plugin $plugin */
        $plugin = app(PluginRepository::class)->whereName('facebook');

        $plugin->setHide(false)->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var Plugin $plugin */
        $plugin = app(PluginRepository::class)->whereName('facebook');

        $plugin->setHide(true)->save();
    }
}
