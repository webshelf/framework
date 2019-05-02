<?php

namespace Tests\Sitemap;

use Carbon\Carbon;
use Tests\TestCase;
use App\Modules\Pages\Model\PageOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SitemapResponseTest.
 */
class SitemapResponseTest extends TestCase
{
    /*
     * Database traits.
     */
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_creates_a_sitemap()
    {
        $this->get('/sitemap.xml')->assertHeader('Content-type', 'text/xml; charset=UTF-8')->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_shows_pages_on_sitemap()
    {
        $page = factory('App\Model\Page')->create(['option' => PageOptions::OPTION_SITEMAP]);

        $response = $this->get('/sitemap.xml');

        $response->assertSee('<loc>'.$page->path().'</loc>');
        $response->assertSee('<lastmod>'.$page->updated_at->format('Y-m-d').'</lastmod>');

        $this->assertCount(2, $response->getOriginalContent()->getData()['urlset']);
    }

    /**
     * @test
     */
    public function it_shows_articles_on_sitemap_except_unpublished()
    {
        $collection = factory('App\Model\Article', 2)->create(['status' => true]);
        $unpublished = factory('App\Model\Article')->create(['unpublish_date' => Carbon::now()]);

        $response = $this->get('/sitemap.xml');

        $this->assertCount(3, $response->getOriginalContent()->getData()['urlset']);

        $response->assertSee($collection->random()->path())->assertDontSee($unpublished->path());
    }
}
