<?php

use App\Model\Activity;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('activity_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->integer('interaction_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->string('activity_type');
            $table->softDeletes();
            $table->timestamps();
        });

        $activity = new Activity;
        $activity->setAccount(1);
        $activity->setInteractionID(3);
        $activity->setActivityID(1);
        $activity->setActivityType('page');
        $activity->save();

        $activity = new Activity;
        $activity->setAccount(1);
        $activity->setInteractionID(3);
        $activity->setActivityID(1);
        $activity->setActivityType('menu');
        $activity->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('activity_log');
    }
}
