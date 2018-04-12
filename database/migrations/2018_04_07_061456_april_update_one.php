<?php

use App\Model\Setting;
use Illuminate\Database\Migrations\Migration;

class AprilUpdateOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $setting = new Setting;
        $setting->setAttribute('key', 'google_site_tag');
        $setting->save();
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
