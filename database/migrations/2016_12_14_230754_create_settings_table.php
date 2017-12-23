<?php

use App\Model\Setting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('value')->nullable();
            $table->string('default')->nullable();
            $table->timestamps();
        });

        $setting = new Setting;
        $setting->setKey('website_name');
        $setting->setShadow('Business Name CMS');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('website_copyright');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_indexing');
        $setting->setShadow(false);
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_text');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_position');
        $setting->setShadow('left');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_separator');
        $setting->setShadow('|');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('page_keywords');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('page_description');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('maintenance_mode');
        $setting->setShadow(true);
        $setting->save();

        $setting = new Setting;
        $setting->setKey('address');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('phone_number');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('fax_number');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('email_address');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('facebook_id');
        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('settings');
    }
}
