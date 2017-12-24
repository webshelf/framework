<?php

use App\Model\Setting;
use Illuminate\Database\Migrations\Migration;

class AddNewSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @param Setting $setting
     * @return void
     */
    public function up()
    {
        $setting = new Setting;
        $setting->setKey('website_logo');
        $setting->setShadow('uploads/logo.png');
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
