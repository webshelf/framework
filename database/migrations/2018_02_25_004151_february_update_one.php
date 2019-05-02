<?php

use App\Model\Categories;
use Illuminate\Support\Facades\Schema;
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
        Schema::table('plugins', function (Blueprint $table) {
            $table->dropColumn('version');
        });

        Schema::table('plugins', function (Blueprint $table) {
            $table->dropColumn('icon');
        });

        Schema::create('article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->boolean('status')->default(1);
            $table->integer('editor_id');
            $table->integer('creator_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Categories::create(['slug' => 'general', 'title' => 'General', 'status' => true, 'editor_id' => 1, 'creator_id' => 1]);

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->longText('content');
            $table->string('featured_img')->nullable();
            $table->integer('views')->default(0);
            $table->integer('sitemap')->default(1);
            $table->unsignedInteger('category_id')->default(1);
            $table->integer('editor_id');
            $table->integer('creator_id');
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
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
