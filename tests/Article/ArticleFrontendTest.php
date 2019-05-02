<?php

namespace Tests\Article;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleFrontendTest extends TestCase
{
    /*
     * Provide fake content
     */
    use WithFaker;
    /*
     * Reset database after each test.
     */
    use RefreshDatabase;

    /**
     * The Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @test
     */
    public function an_articles_views_are_incremented_after_being_viewed()
    {
        $article = factory('App\Model\Article')->create(['views' => 0]);

        $this->get($article->path());

        $this->assertDatabaseHas('articles', ['views' => 1]);
    }

    /**
     * @test
     */
    public function it_should_show_an_article_that_is_published()
    {
        $article = factory('App\Model\Article')->create(['views' => 0]);

        $response = $this->get($article->path());

        $response->assertSee($article->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function it_should_not_show_an_article_that_is_not_published()
    {
        $this->withExceptionHandling();

        $article = factory('App\Model\Article')->create(['views' => 0, 'publish_date' => Carbon::yesterday(), 'unpublish_date' => Carbon::now()]);

        $response = $this->get($article->path());

        $response->assertStatus(404);
    }

    /**
     * @test
     * t     */
    public function a_collection_of_articles_can_be_viewed_on_the_frontpage_except_unpublished()
    {
        $collection = factory('App\Model\Article', 5)->create();
        $unpublished = factory('App\Model\Article')->create(['unpublish_date' => Carbon::now()]);

        $response = $this->get('articles');

        $response->assertSee($collection->random()->title)->assertDontSee($unpublished->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function a_category_can_have_a_collection_of_articles_on_the_frontpage_except_unpublished()
    {
        $category = factory('App\Model\Categories')->create();
        $unpublished = factory('App\Model\Article')->create(['unpublish_date' => Carbon::now()]);

        $collection = factory('App\Model\Article', 5)->create(['category_id' => $category->id]);

        $response = $this->get('articles/'.$category->slug);

        $response->assertSee($collection->random()->title)->assertDontSee($unpublished->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function articles_can_be_searched_on_the_frontpage()
    {
        $collection = factory('App\Model\Article', 10)->create();

        $article = $collection->random();

        $response = $this->get('/articles/search?query='.$article->title);

        $response->assertSee($article->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function it_should_not_show_unpublished_articles_on_search()
    {
        $unpublished = factory('App\Model\Article')->create(['unpublish_date' => Carbon::now()]);

        $response = $this->get('/articles/search?query='.$unpublished->title);

        $response->assertDontSee($unpublished->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function view_all_articles_by_creator_on_the_frontpage_except_unpublished()
    {
        $this->markTestSkipped('Cannot query empty instance [App/Model/Categories]');

        $account = factory('App\Model\Account')->create();

        $article = factory('App\Model\Article')->create(['creator_id' => $account->id]);
        $unpublished = factory('App\Model\Article')->create(['unpublish_date' => Carbon::now()]);

        $response = $this->get('/articles/creator/'.$account->username);

        $response->assertSee($article->title)->assertDontSee($unpublished->title)->assertViewIs('articles')->assertOk();
    }
}
