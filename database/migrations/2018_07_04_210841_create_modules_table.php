<?php

use App\Model\Page;
use App\Modules\Pages\Model\PageTypes;
use Illuminate\Support\Facades\Schema;
use App\Modules\Pages\Model\PageOptions;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('module')->after('option')->nullable();
        });

        Page::firstOrCreate([
            'seo_title' => 'Articles',
            'identifier' => 'articles',
            'slug' => 'articles',
            'type' => PageTypes::TYPE_MODULE,
            'option' => PageOptions::OPTION_DISABLED,
        ]);

        foreach (Page::all() as $page) {
            if ($page->type & PageTypes::TYPE_PLUGIN) {
                $page->type = $page->type & ~PageTypes::TYPE_PLUGIN;
                $page->type = $page->type | PageTypes::TYPE_MODULE;
            }

            if ($page->identifier == 'articles') {
                $page->module = 'articles';
                $page->type = PageTypes::TYPE_MODULE | PageTypes::TYPE_ROUTER;
            }

            if ($page->identifier == 'newsletter.success') {
                $page->module = 'newsletters';
                $page->option = $page->option | PageOptions::OPTION_DISABLED;
            }

            if ($page->identifier == 'error.404') {
                $page->module = 'errors';
            }

            $page->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
