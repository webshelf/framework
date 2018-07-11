<?php

namespace Tests\Article;

use Carbon\Carbon;
use Tests\TestCase;
use App\Model\Article;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlePublishingTest extends TestCase
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
     * @test
     */
    public function it_should_not_show_articles_with_publish_date_greater_than_today()
    {
        factory('App\Model\Article')->create(['publish_date' => Carbon::tomorrow()]);

        $this->assertCount(0, Article::all());
    }

    /**
     * @test
     */
    public function it_should_show_articles_published_today()
    {
        factory('App\Model\Article')->create(['publish_date' => Carbon::today()]);

        $this->assertCount(1, Article::all());
    }

    /**
     * @test
     */
    public function it_should_not_show_articles_with_unpublish_date_less_than_today()
    {
        factory('App\Model\Article')->create(['publish_date' => Carbon::yesterday(), 'unpublish_date' => Carbon::today()]);

        $this->assertCount(0, Article::all());
    }

    /**
     * @test
     */
    public function it_should_show_articles_with_unpublish_date_tommorow()
    {
        factory('App\Model\Article')->create(['publish_date' => Carbon::now(), 'unpublish_date' => Carbon::tomorrow()]);

        $this->assertCount(1, Article::all());
    }
}
