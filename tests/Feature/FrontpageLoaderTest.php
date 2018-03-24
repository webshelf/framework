<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 16:57.
 */

namespace Tests\Feature;

use App\Model\Page;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use App\Classes\Library\PageLoader\Frontpage;

/**
 * Class FrontpageLoaderTest.
 */
class FrontpageLoaderTest extends TestCase
{
    /**
     * @test
     */
    public function a_frontpage_should_be_constructable()
    {
        $webpage = (new Frontpage($this->page(), new Collection))->draft();

        $this->assertNotEmpty($webpage);
        $this->assertNotEmpty($webpage->contact);
        $this->assertNotEmpty($webpage->frame);
        $this->assertNotEmpty($webpage->navigation);
        $this->assertNotEmpty($webpage->plugins);
    }
    
    public function default_frontpage_views()
    {
        Route::get('/', function () {
            return (new Frontpage($this->page(), new Collection))->publish();
        });

        Route::get('/test', function () {
            return (new Frontpage($this->page(), new Collection))->publish();
        });

        $this->visit('/')->assertViewIs('website::index');
        $this->visit('/test')->assertViewIs('website::page');
    }

    /**
     * @test
     */
    public function page_title_should_append_text_with_positioning()
    {
        $webpage = (new Frontpage($this->page(), new Collection))->draft();

        settings()->set('seo_text', 'Unit Testing Right');
        settings()->set('seo_position', 'right');
        settings()->set('seo_separator', '-');

        $this->assertSame('Homepage - Unit Testing Right', $webpage->title());

        settings()->set('seo_text', 'Unit Testing Left');
        settings()->set('seo_position', 'left');
        settings()->set('seo_separator', '|');

        $this->assertSame('Unit Testing Left | Homepage', $webpage->title());
    }

    private function page()
    {
        $page = new Page([
            'slug' => 'index',
            'seo_title' => 'Homepage'
        ]);

        return $page;
    }
}
