<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Model\Article;
use Illuminate\Support\Facades\Event;
use App\Modules\Articles\Events\ArticleCreated;
use App\Modules\Articles\Events\ArticleDeleted;
use App\Modules\Articles\Events\ArticleUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleBackendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_should_return_an_article_listing()
    {
        // the database should have an article.
        $article = factory('App\Model\Article')->create();

        // so that when a user signs in.
        $this->signIn();

        // and visits the articles listing.
        $response = $this->visit('admin/articles');

        // they should see the article in the database on the page.
        $response->assertSee(ucwords($article->title));
    }

    /**
     * @test
     */
    public function a_form_can_be_used_to_create_articles()
    {
        // when a user signs in.
        $this->signIn();

        // they can visit a url.
        $response = $this->visit('admin/articles/create');

        // and see a form.
        $response->assertSee('<button type="submit" class="btn btn-create">Create Article</button>');
    }

    /**
     * @test
     */
    public function a_form_can_be_used_to_edit_articles()
    {
        // when a user signs in.
        $this->signIn();

        // looks up an already existing article.
        $article = factory('App\Model\Article')->create();

        // and attempts to edit.
        $response = $this->get("admin/articles/{$article->slug}/edit");

        // they should see a form.
        $response->assertSee('<button type="submit" class="btn btn-create">Edit Article</button>');
    }

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

    /**
     * @test
     * @throws \Exception
     */
    public function an_already_existing_article_can_be_updated_and_fire_an_event_once_saved()
    {
        // we expect an event to be fired.
        $this->expectsEvents(ArticleUpdated::class);

        // when a user signs in
        $this->signIn();

        // edits an already existing article.
        $article = factory('App\Model\Article')->create();

        // create new article data for updating the existing.
        $changes = factory('App\Model\Article')->make(['title' => 'foo', 'content' => 'bar']);

        // and posts it to the url.
        $this->put("admin/articles/{$article->slug}", $changes->toArray());

        // then the framework should store the changes in the database.
        $this->assertDatabaseHas('articles', ['title' => 'foo', 'content' => 'bar']);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function an_already_existing_article_can_be_deleted_and_fire_an_event_once_saved()
    {
        // we expect an event to be fired.
        $this->expectsEvents(ArticleDeleted::class);

        // when the user is signed in.
        $this->signIn();

        // uses an already existing article.
        $article = factory('App\Model\Article')->create(['title' => 'foo']);

        // and deletes it.
        $this->delete("admin/articles/{$article->slug}");

        // it should be removed from the database.
        $this->assertDatabaseHas('articles', ['title' => 'foo', 'deleted_at' => now()]);
    }
}
