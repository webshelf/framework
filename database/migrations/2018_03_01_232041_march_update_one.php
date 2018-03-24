<?php

use App\Model\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Plugins\Newsletters\Model\Newsletter;
use Illuminate\Database\Migrations\Migration;

class MarchUpdateOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $plugin = new \App\Model\Plugin();

        $plugin->setAttribute('name', 'newsletters');
        $plugin->setAttribute('enabled', false);
        $plugin->setAttribute('is_frontend', true);
        $plugin->setAttribute('is_backend', true);
        $plugin->setAttribute('required', false);
        $plugin->save();

        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('content');
            $table->integer('emailCount');
            $table->boolean('deliveryStatus');
            $table->integer('editor_id');
            $table->integer('creator_id');
            $table->timestamps();
        });

        Schema::create('newsletter_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255)->unique();
            $table->timestamps();
        });

        Schema::create('newsletter_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('editor_id');
            $table->integer('creator_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('identifier')->nullable()->after('id')->index();
            $table->boolean('special')->default(0)->after('editable');
        });

        /** @var Page $page */
        $page = app(Page::class);
        $page->setAttribute('identifier', Newsletter::VIEW_NEWSLETTER_SUCCESS);
        $page->setAttribute('title', 'Thank You Newsletter');
        $page->setAttribute('content', '<h1>Newsletter Signup Complete</h1> <p>Thank you for subscribing to our newsletter.</p>');
        $page->setAttribute('editable', true);
        $page->setAttribute('special', true);
        $page->setAttribute('sitemap', false);
        $page->setAttribute('enabled', true);
        $page->save();
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
