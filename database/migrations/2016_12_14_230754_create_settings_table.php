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
        $setting->setKey('site_name');
        $setting->setShadow('Business Name CMS');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('feature_hide_disabled');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('search_engine_indexing');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_title_text_append');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_title_text_position');
        $setting->setShadow('left');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_title_text_seperator');
        $setting->setShadow('|');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_keywords');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('seo_description');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('google_analitycs_code');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('google_webmaster_code');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('bing_webmaster_code');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('enable_website');
        $setting->setValue(true);
        $setting->save();

        $setting = new Setting;
        $setting->setKey('website_copyright');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('address_name');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('address_location');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('address_county');
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
        $setting->setKey('site_breadcrumbs');
        $setting->setShadow(true);
        $setting->save();

        $setting = new Setting;
        $setting->setKey('db_update_time');
        $setting->setShadow('Never');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('fb_page_id');
        $setting->save();

        $setting = new Setting;
        $setting->setKey('google_project_id');
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
