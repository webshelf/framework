<?php

use App\Model\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Modules\Newsletters\Model\Newsletter;

class MarchUpdateOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->string('email', 191)->unique();
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
