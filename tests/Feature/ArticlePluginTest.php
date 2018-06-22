<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Model\Plugin;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlePluginTest extends TestCase
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
     * @test
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
     * t     */
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

        $response = $this->get('articles/'.$category->slug);

        $response->assertSee($collection->random()->title)->assertViewIs('articles')->assertOk();
    }

    /**
     * @test
     */
    public function articles_can_be_searched_on_the_frontpage()
    {
        $collection = factory('App\Plugins\Articles\Model\Article', 10)->create();

        $article = $collection->random();

        $response = $this->get('/articles/search?query='.$article->title);

        $response->assertSee($article->title)->assertViewIs('articles')->assertOk();
    }

//     /**
//     * @test
//     */
//     public function a_new_article_can_be_created()
//     {
//         $this->signIn();

//         $article = factory('App\Plugins\Articles\Model\Article')->make();

//         $response = $this->post('/admin/articles', [
//             'title' => $article->title,
//             'content' => $article->content,
//             'category' => $article->category_id,
//             'publish_date' => $article->publish_date,
//         ]);

//         $this->assertDatabaseHas('articles', [
//             'title' => $article->title,
//             'content' => $article->content
//         ]);

//         $response->assertRedirect("admin/articles");

//     }
}
