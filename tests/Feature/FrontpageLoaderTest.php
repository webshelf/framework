<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 16:57
 */

namespace Tests\Feature;

use App\Classes\Library\PageLoader\Webpage;
use App\Model\Menu;
use App\Model\Page;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use App\Classes\Library\PageLoader\Frontpage;
use Illuminate\Support\Facades\Route;

/**
 * Class FrontpageLoaderTest
 *
 * @package Tests\Feature
 */
class FrontpageLoaderTest extends TestCase
{

    /**
     * @test
     */
    public function a_frontpage_should_be_constructable()
    {
        $page = factory(Page::class)->make();
        $navs = factory(Menu::class, 6)->states('parent')->make();

        $frontpage = (new Frontpage($page, $navs));

        $this->assertNotEmpty($frontpage->webpage->page);
        $this->assertNotEmpty($frontpage->webpage->contact);
        $this->assertNotEmpty($frontpage->webpage->site);
        $this->assertNotEmpty($frontpage->webpage->collections);
    }

    /**
     * @test
     */
    public function frontpage_should_be_publishable_with_default_template()
    {
        $page = factory(Page::class)->make();
        $navs = factory(Menu::class, 6)->states('parent')->make();

        $index = $this->publish($frontpage = (new Frontpage($page, $navs)), '/');
        $page = $this->publish($frontpage = (new Frontpage($page, $navs)), '/test');

        $index->assertViewIs('website::index')->assertViewHas('webpage', $frontpage->webpage);
        $page->assertViewIs('website::page')->assertViewHas('webpage', $frontpage->webpage);
    }

    /**
     * Build a route and return the visit response.
     * @param Frontpage $frontpage
     * @param string $url
     * @param string|null $template
     * @return $this|\Illuminate\Foundation\Testing\TestResponse
     */
    private function publish(Frontpage $frontpage, string $url = '/', string $template = null)
    {
        Route::get($url, function() use ($frontpage, $template) {
            return $frontpage->publish($template, false);
        });

        return $this->visit($url);
    }

}
