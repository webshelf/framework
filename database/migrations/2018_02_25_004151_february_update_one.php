<?php

use App\Model\Plugin;
use App\Model\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FebruaryUpdateOne extends Migration
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

        Schema::table('plugins', function (Blueprint $table) {
            $table->dropColumn('version');
            $table->dropColumn('icon');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->longText('content');
            $table->string('featured_img')->nullable();
            $table->integer('views')->default(0);
            $table->integer('sitemap')->default(1);
            $table->unsignedInteger('category_id')->nullable();
            $table->integer('editor_id');
            $table->integer('creator_id');
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->boolean('status')->default(1);
            $table->integer('editor_id');
            $table->integer('creator_id');
            $table->softDeletes();
            $table->timestamps();
        });

        /**
         * Store youtube url.
         */
        $setting = new Setting;
        $setting->setAttribute('key', 'youtube_url');
        $setting->save();

        /**
         * Store facebook url.
         */
        $setting = new Setting;
        $setting->setAttribute('key', 'facebook_url');
        $setting->save();

        /**
         * Store twitter url.
         */
        $setting = new Setting;
        $setting->setAttribute('key', 'twitter_url');
        $setting->save();

        /*
         * INDEX ALL NEW MATERIAL FOR SEARCHING.
         */
        // Artisan::call('scout:mysql-index');
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
