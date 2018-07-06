<?php

use App\Model\Page;
use App\Plugins\Pages\Model\PageTypes;
use Illuminate\Support\Facades\Schema;
use App\Plugins\Pages\Model\PageOptions;
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
        $page = Page::firstOrCreate([
            'seo_title' => 'Articles',
            'identifier' => 'articles',
            'slug' => 'articles',
            'type' => PageTypes::TYPE_MODULE,
            'option' => PageOptions::OPTION_DISABLED,
        ]);

        Schema::table('pages', function (Blueprint $table) {
            $table->string('module')->after('option')->nullable();
        });
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
