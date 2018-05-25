<?php

use App\Model\Link;
use App\Model\Menu;
use App\Model\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_id');
            $table->string('from_type');
            $table->index(['from_id', 'from_type']);
            $table->unsignedInteger('to_id')->nullable();
            $table->string('to_type')->nullable();
            $table->index(['to_id', 'to_type']);
            $table->string('external')->nullable();
            $table->timestamps();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->removeColumn('hyperlink');
            $table->removeColumn('page_id');
        });

        /**
         * Link the homepage menu to the homepage page.
         */
        $page = app(PageRepository::class)->whereID(1);
        $menu = app(MenuRepository::class)->whereID(1);

        /** @var Link $link */
        $link = app(Link::class);

        $link->model($menu, $page);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
