<?php

namespace Tests\Feature;

use Illuminate\Support\ServiceProvider;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Plugin;
use App\Providers\RouteServiceProvider;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\Routing\Tests\RouteCollectionTest;
use Illuminate\Support\Facades\Route;

class ArticlePluginTest extends TestCase
{

    /**
     * Provide fake content
     */
    use WithFaker;

    /**
     * Reset database after each test.
     */
    use RefreshDatabase;

    /**
     * The plugin model for articles.
     *
     * @var Article
     */
    private $plugin;

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

        $this->plugin = Plugin::install('articles');

        Route::middleware('web', 'auth', 'gateway')->group(base_path(sprintf('app/Plugins/%s/Routes/backend.php', 'Articles')));

        Route::middleware('web')->group(base_path(sprintf('app/Plugins/%s/Routes/frontend.php', 'Articles')));

        // $this->app['router']->getRoutes()->refreshNameLookups();
    }

    /**
    * @test
    */
    public function a_single_article_can_be_viewed_on_the_frontpage()
    {
        $article = factory('App\Plugins\Articles\Model\Article')->create(['views' => 0]);

        $response = $this->get($article->path());

        $this->assertDatabaseHas('articles', ['views' => 1]);

        $response->assertSee($article->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
t     */
    public function all_articles_can_be_viewed_on_the_frontpage()
    {
        $collection = factory('App\Plugins\Articles\Model\Article', 5)->create();

        $response = $this->get('articles');

        $response->assertSee($collection->random()->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function all_articles_inside_a_category_can_be_viewed_on_the_frontpage()
    {
        $category = factory('App\Plugins\Articles\Model\Categories')->create();

        $collection = factory('App\Plugins\Articles\Model\Article', 5)->create(['category_id' => $category->id]);

        $response = $this->get('articles/' . $category->slug);

        $response->assertSee($collection->random()->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function articles_can_be_searched_on_the_frontpage()
    {
        $collection = factory('App\Plugins\Articles\Model\Article', 10)->create();

        $article = $collection->random();

        $response = $this->get('/articles/search?query=' . $article->title);

        $response->assertSee($article->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function view_all_articles_by_creator_on_the_frontpage()
    {
        $account = factory('App\Model\Account')->create();

        $articles = factory('App\Plugins\Articles\Model\Article', 3)->create(['creator_id' => $account->id]);

        $response = $this->get('/articles/creator/' . $account->username);

        $response->assertSee($articles->random()->title)->assertViewIs('articles')->assertOk();
    }
}
