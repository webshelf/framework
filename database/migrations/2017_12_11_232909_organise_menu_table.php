<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Menu;

class OrganiseMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('icon');

            $table->renameColumn('link', 'hyperlink');
            $table->renameColumn('page_id', 'page_id');
            $table->renameColumn('menu_id', 'parent_id');
            $table->renameColumn('order_id', 'order');
            $table->renameColumn('required', 'lock');
            $table->renameColumn('enabled', 'status');
            $table->renameColumn('editor_id', 'editor_id');
            $table->renameColumn('creator_id', 'creator_id');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('lock')->default(0)->nullable(false)->change();
        });

        $menu = new Menu;
        $menu->title = ('Homepage');
        $menu->target = ('_self');
        $menu->order = 1;
        $menu->page_id = 1;
        $menu->status = true;
        $menu->lock = true;
        $menu->creator_id = 1;
        $menu->save();
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
