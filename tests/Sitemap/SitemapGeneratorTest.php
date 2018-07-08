<?php /** @noinspection ALL */

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Collection;
use App\Modules\Sitemap\SitemapGenerator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Sitemap\SitemapConstants as Sitemap;

/**
 * Class SitemapGeneratorTest
 *
 * @package Tests\Feature
 */
class SitemapGeneratorTest extends TestCase
{

    /**
     * Faker library.
     */
    use WithFaker;

    /**
     * @var SitemapGenerator
     */
    protected $generator;

    /**
     * Setup test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->generator = new SitemapGenerator(new Collection);
    }

    /**
     * @test
     */
    public function it_should_add_urls()
    {
        $this->generator->add($this->faker->url);

        $this->assertCount(1, $this->generator->collection());
    }

    /**
     * @test
     */
    public function it_should_add_multiple_urls()
    {
        $this->generator->add($this->faker->url);
        $this->generator->add($this->faker->url);

        $this->assertCount(2, $this->generator->collection());
    }

    /**
     * @test
     */
    public function it_can_have_a_last_modified_date()
    {
        $this->generator->add($this->faker->url)->modified(Carbon::create(2018, 7, 7));

        $this->assertTrue(array_has($this->generator->collection(), '0.loc'));
    }

    /**
     * @test
     */
    public function it_can_have_a_change_frequency()
    {
        $this->generator->add($this->faker->url)->withFrequency(Sitemap::FREQUENCY_DAILY);

        $this->assertTrue(array_has($this->generator->collection(), '0.changefreq'));
    }

    /**
     * @test
     */
    public function it_can_have_a_priority()
    {
        $this->generator->add($this->faker->url)->andPriority(Sitemap::PRIORITY_HIGHEST);

        $this->assertTrue(array_has($this->generator->collection(), '0.priority'));
    }
}
