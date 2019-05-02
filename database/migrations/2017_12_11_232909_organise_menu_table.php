<?php

use App\Model\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('icon');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('link', 'hyperlink');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('page_id', 'page_id');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('menu_id', 'parent_id');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('order_id', 'order');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('required', 'lock');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('enabled', 'status');
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('editor_id', 'editor_id');
        });

        Schema::table('menus', function (Blueprint $table) {
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
