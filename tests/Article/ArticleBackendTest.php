<?php

namespace Tests\Feature;

use App\Modules\Articles\Events\ArticleCreated;
use App\Modules\Articles\Events\ArticleUpdated;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleBackendTest extends TestCase
{

    //use RefreshDatabase;

    /**
     * @test
     * @throws \Exception
     */
    public function a_posted_article_should_fire_an_event_once_saved()
    {
        // we expect an event to be fired.
        $this->expectsEvents(ArticleCreated::class);

        // when a user signs in
        $this->signIn();

        // and created an article data
        $article = factory('App\Model\Article')->make();

        // and posts it to the url.
        $this->post('admin/articles', $article->toArray());

        // then the framework should be stored in the database.
        $this->assertDatabaseHas('articles', ['title' => $article->title, 'content' => $article->content]);
    }
}
