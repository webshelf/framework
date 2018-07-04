<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Configuration;

class SystemConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // define the database.
        Schema::create('system_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->index();
            $table->string('value')->nullable();
            $table->text('description');
            $table->timestamp('updated_at')->useCurrent();
        });

        // destroy the old settings database.
        Schema::drop('settings');

        // Add the configuration settings to database.
        Configuration::create(['key' => 'app.name', 'value' => 'Your CMS', 'description' => 'The name of your application.']);
        Configuration::create(['key' => 'app.mode', 'value' => 'normal', 'description' => 'The current state of your application']);
        Configuration::create(['key' => 'app.logo', 'value' => 'uploads/logo.png', 'description' => 'The logo that visualizes your application.']);
        Configuration::create(['key' => 'website.tag.title.text', 'value' => null, 'description' => 'Defines an extra title to be appended to all page tag titles.']);
        Configuration::create(['key' => 'website.tag.title.position', 'value' => 'right', 'description' => 'Defines the position the text should be placed on.']);
        Configuration::create(['key' => 'website.tag.title.separator', 'value' => '-', 'description' => 'Defines the text that seperates the appended text.']);
        Configuration::create(['key' => 'website.tag.keywords.default', 'value' => null, 'description' => 'Set the default keywords to be used on pages without set keywords.']);
        Configuration::create(['key' => 'website.tag.description.default', 'value' => null, 'description' => 'Set the default description to be used on pages without default kewords.']);
        Configuration::create(['key' => 'website.contact.address', 'value' => null, 'description' => 'The contact address for visitors viewing your website.']);
        Configuration::create(['key' => 'website.contact.email', 'value' => null, 'description' => 'The contact email for visitors viewing your website.']);
        Configuration::create(['key' => 'website.contact.phone', 'value' => null, 'description' => 'The contact phone for visitors viewing your website.']);
        Configuration::create(['key' => 'website.contact.fax', 'value' => null, 'description' => 'The contact fax for visitors viewing your website.']);
        Configuration::create(['key' => 'website.webmaster.google.tracking', 'value' => null, 'description' => 'The tracking code required for google analytics tracking.']);
    }
}
