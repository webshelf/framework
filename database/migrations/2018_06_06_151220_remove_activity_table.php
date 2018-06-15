<?php

use Illuminate\Database\Migrations\Migration;

class RemoveActivityTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::drop('activity');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
