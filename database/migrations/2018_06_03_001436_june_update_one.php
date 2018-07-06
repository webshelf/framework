<?php

use App\Model\Page;
use App\Modules\Pages\Model\PageTypes;
use Illuminate\Support\Facades\Schema;
use App\Modules\Pages\Model\PageOptions;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JuneUpdateOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            // $table->renameColumn('seo_title', 'title');
            // $table->renameColumn('seo_description', 'description');
            // $table->renameColumn('seo_keywords', 'keywords');

            $table->binary('option')->after('views');
            $table->binary('type')->after('views');

            // $table->dropColumn('editable');
            // $table->dropColumn('special');
            // $table->dropColumn('enabled');
            // $table->dropColumn('plugin');
            // $table->dropColumn('sitemap');
        });

        Artisan::call('upgrade:june_one');

        $page = app(Page::class);
        $page->title = '404 Page Not Found';
        $page->content = '<h1>404 - Page not found</h1>';
        $page->identifier = 'error.404';
        $page->type = PageTypes::TYPE_ERROR;
        $page->option = PageOptions::OPTION_PUBLIC;
        $page->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('option');
        });
    }
}
