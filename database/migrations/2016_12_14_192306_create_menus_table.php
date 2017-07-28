<?php

use App\Model\Menu;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Classes\Repositories\AccountRepository;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('page_id')->nullable();
            $table->string('target');
            $table->unsignedInteger('menu_id')->nullable();
            $table->integer('order_id')->default(99);
            $table->unsignedInteger('creator_id');
            $table->tinyInteger('enabled')->nullable();
            $table->tinyInteger('required')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Auth::login(app(AccountRepository::class)->whereID(1));

        $menu = new Menu;
        $menu->setSlug('index');
        $menu->setTitle('Homepage');
        $menu->setTarget('_self');
        $menu->setOrderID(1);
        $menu->setPageID(1);
        $menu->setEnabled(true);
        $menu->setRequired(true);
        $menu->setCreatorID(1);
        $menu->withoutTracking()->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('menus');
    }
}
