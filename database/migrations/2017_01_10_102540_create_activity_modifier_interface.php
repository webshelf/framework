<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityModifierInterface extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('publisher_id');
            $table->unsignedInteger('creator_id')->default(1)->after('editable');
            $table->unsignedInteger('editor_id')->default(1)->after('creator_id');
        });

        \Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('creator_id');
        });

        \Schema::table('menus', function (Blueprint $table) {
            $table->unsignedInteger('creator_id')->default(1)->after('required');
            $table->unsignedInteger('editor_id')->default(1)->after('creator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table('pages', function (Blueprint $table) {
            $table->unsignedInteger('publisher_id');
            $table->dropColumn('editor_id');
            $table->dropColumn('creator_id');
        });

        \Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('editor_id');
            $table->dropColumn('creator_id');
        });
    }
}
