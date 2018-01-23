<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Plugin;

/**
 * Class AddArticlesPlugins
 */
class AddArticlesPlugins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $plugin = new Plugin;

        $plugin->setAttribute('name', 'articles');
        $plugin->setAttribute('version', '1.0');
        $plugin->setAttribute('icon', 'fa-book');
        $plugin->setAttribute('enabled', false);
        $plugin->setAttribute('is_frontend', true);
        $plugin->setAttribute('is_backend', true);
        $plugin->setAttribute('required', false);

        $plugin->save();

        /** @var \App\Classes\Repositories\PluginRepository $pluginRepository */
        $pluginRepository = app(\App\Classes\Repositories\PluginRepository::class);

        $pluginRepository->whereName('menus')->setAttribute('required', true)->save();
        $pluginRepository->whereName('pages')->setAttribute('required', true)->save();

        Schema::table('plugins', function(Blueprint $table)
        {
            $table->dropColumn('version');
            $table->dropColumn('icon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        //
    }
}
