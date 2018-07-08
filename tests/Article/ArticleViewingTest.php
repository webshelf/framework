<?php

namespace Tests\Article;

use Tests\TestCase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleViewingTest extends TestCase
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
     * Setup the testing for this test.
     */
    public function setUp()
    {
        parent::setUp();

        Route::middleware('web', 'auth', 'gateway')->group(base_path('app/Modules/Articles/Routes/backend.php'));

        Route::middleware('web')->namespace('App\Modules\Articles')->group(base_path('app/Modules/Articles/Routes/frontend.php'));
    }

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
    public function a_single_article_can_be_viewed_on_the_frontpage()
    {
        $article = factory('App\Model\Article')->create(['views' => 0]);

        $response = $this->get($article->path());

        $response->assertSee($article->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     * t     */
    public function a_collection_of_articles_can_be_viewed_on_the_frontpage()
    {
        $collection = factory('App\Model\Article', 5)->create();

        $response = $this->get('articles');

        $response->assertSee($collection->random()->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function a_category_can_have_a_collection_of_articles_on_the_frontpage()
    {
        $category = factory('App\Model\Categories')->create();

        $collection = factory('App\Model\Article', 5)->create(['category_id' => $category->id]);

        $response = $this->get('articles/'.$category->slug);

        $response->assertSee($collection->random()->title)->assertViewIs('articles')->assertOk();
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
    public function view_all_articles_by_creator_on_the_frontpage()
    {
        $account = factory('App\Model\Account')->create();

        $articles = factory('App\Model\Article', 3)->create(['creator_id' => $account->id]);

        $response = $this->get('/articles/creator/'.$account->username);

        $response->assertSee($articles->random()->title)->assertViewIs('articles')->assertOk();
    }
}
