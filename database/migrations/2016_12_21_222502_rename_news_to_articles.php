<?php

use Illuminate\Database\Migrations\Migration;

class RenameNewsToArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::rename('news', 'articles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::rename('articles', 'news');
    }
}
