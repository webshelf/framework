<?php

use App\Model\Page;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Classes\Repositories\AccountRepository;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->string('banner')->nullable();
            $table->string('seo_title');
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->tinyInteger('sitemap')->nullable();
            $table->tinyInteger('enabled')->nullable();
            $table->string('plugin')->nullable();
            $table->tinyInteger('editable')->nullable()->default(1);
            $table->unsignedInteger('publisher_id')->nullable();
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
        \Schema::dropIfExists('pages');
    }
}
