<?php

use App\Model\Plugin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('plugins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('version');
            $table->string('icon');
            $table->tinyInteger('enabled')->nullable();
            $table->tinyInteger('installed')->nullable();
            $table->tinyInteger('hidden')->nullable();
            $table->tinyInteger('required')->nullable();
            $table->tinyInteger('is_frontend')->nullable();
            $table->tinyInteger('is_backend')->nullable();
            $table->timestamps();
        });

        /*
         * DATA REQUIRED FOR APPLICATION CORE LOADING.
         */
        $plugin = new Plugin;
        $plugin->setName('products');
        $plugin->setVersion('1.0');
        $plugin->setIcon('fa-book');
        $plugin->setEnabled(true);
        $plugin->setRequired(true);
        $plugin->setFrontEnd(false);
        $plugin->setBackEnd(true);
        $plugin->save();

        $plugin = new Plugin;
        $plugin->setName('menus');
        $plugin->setVersion('1.0');
        $plugin->setIcon('fa-bars');
        $plugin->setEnabled(true);
        $plugin->setFrontEnd(false);
        $plugin->setBackEnd(true);
        $plugin->save();

        $plugin = new Plugin;
        $plugin->setName('pages');
        $plugin->setVersion('1.0');
        $plugin->setIcon('fa-paperclip');
        $plugin->setEnabled(true);
        $plugin->setFrontEnd(true);
        $plugin->setBackEnd(true);
        $plugin->save();

        $plugin = new Plugin;
        $plugin->setName('news');
        $plugin->setVersion('1.0');
        $plugin->setIcon('fa-newspaper-o');
        $plugin->setFrontEnd(true);
        $plugin->setBackEnd(true);
        $plugin->save();

        $plugin = new Plugin;
        $plugin->setName('redirects');
        $plugin->setVersion('1.0');
        $plugin->setIcon('fa-magic');
        $plugin->setFrontEnd(true);
        $plugin->setBackEnd(true);
        $plugin->save();

        $plugin = new Plugin;
        $plugin->setName('facebook');
        $plugin->setVersion('2.8');
        $plugin->setIcon('fa-facebook-official');
        $plugin->setHide(true);
        $plugin->setFrontEnd(true);
        $plugin->setBackEnd(true);
        $plugin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('plugins');
    }
}
