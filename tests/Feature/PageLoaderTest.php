<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 25/03/2018
 * Time: 13:33.
 */

namespace Tests\Feature;

use App\Model\Page;
use Tests\TestCase;
use App\Model\Account;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Classes\Library\PageLoader\Frontpage;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class FrontpageTest.
 */
class PageLoaderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_page_should_be_returned_based_on_uri()
    {
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'enabled'=>true]);

        Route::get('/', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish();
        });
        Route::get('/index', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish();
        });

        $this->get('/')->assertViewHas('webpage')->assertViewIs('website::index')->assertStatus(200);
        $this->get('/index')->assertViewHas('webpage')->assertViewIs('website::index')->assertStatus(200);
    }

    /**
     * @test
     */
    public function frontpage_should_return_maintenance_mode_if_site_is_in_maintenance_mode()
    {
        config()->set('app.mode', 'maintenance');

        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'enabled'=>true]);

        Route::get('/', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish();
        });

        $this->get('/')->assertViewHas('webpage')->assertViewIs('errors::maintenance')->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * @test
     */
    public function frontpage_should_bypass_maintenance_mode_if_permission_allowed()
    {
        config()->set('app.mode', 'maintenance');

        auth()->login(factory(Account::class)->make());

        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'enabled'=>true]);

        Route::get('/', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish();
        });

        $this->get('/')->assertViewHas('webpage')->assertViewIs('website::index')->assertStatus(200);
    }

    /**
     * @test
     */
    public function frontpage_should_return_disabled_if_model_page_is_not_enabled()
    {
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'enabled' => false]);

        Route::get('/', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish();
        });

        $this->get('/')->assertViewHas('webpage')->assertViewIs('errors::disabled')->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function frontpage_can_create_a_non_response_draft_for_testing()
    {
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'enabled' => false]);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertNotEmpty($frontpage);
    }

    /**
     * @test
     */
    public function specified_plugin_template_should_be_loaded()
    {
        $page = new Page(['slug'=>'readme', 'seo_title'=>'PHP Unit Testing', 'enabled'=>true]);

        Route::get('/undefined', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish();
        });
        Route::get('/defined', function () use ($page) {
            return (new Frontpage($page, new Collection))->publish('website::plugin.readme');
        });

        $this->get('/defined')->assertViewHas('webpage')->assertViewIs('website::plugin.readme')->assertStatus(200);
        $this->get('/undefined')->assertViewHas('webpage')->assertViewIs('website::plugin.readme')->assertStatus(200);
    }

    /**
     * @test
     */
    public function webpage_should_contain_a_header()
    {
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'enabled' => false]);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertEquals('PHP Unit Testing', $frontpage->header());
    }

    /**
     * @test
     */
    public function webpage_should_contain_keywords_or_default()
    {
        config()->set('website.tag.keywords.default', 'Unit, Test, Keywords');

        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing']);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertEquals('Unit, Test, Keywords', $frontpage->keywords());

        // model keywords
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'seo_keywords' => 'Page, Keywords']);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertEquals('Page, Keywords', $frontpage->keywords());
    }

    /**
     * @test
     */
    public function webpage_should_contain_description_or_default()
    {
        // default
        settings()->set('page_description', 'Default Description');

        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing']);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertEquals('Default Description', $frontpage->description());

        // model description
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'seo_description'=>'Model Description']);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertEquals('Model Description', $frontpage->description());
    }

    /**
     * @test
     */
    public function webpage_should_contain_content()
    {
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'content'=>'Lorem ipsum']);

        $frontpage = (new Frontpage($page, new Collection))->draft();

        $this->assertEquals('Lorem ipsum', $frontpage->content());
    }

    /**
     * @test
     */
    public function webpage_title_should_append_seo_text_with_positioning()
    {
        $page = new Page(['slug'=>'unit-testing', 'seo_title'=>'PHP Unit Testing', 'content'=>'Lorem ipsum']);

        settings()->set('seo_text', '');

        $frontpage = (new Frontpage($page, new Collection))->draft();
        $this->assertEquals('PHP Unit Testing', $frontpage->title());

        settings()->set('seo_text', 'Success');
        settings()->set('seo_position', 'right');
        settings()->set('seo_separator', '-');

        $frontpage = (new Frontpage($page, new Collection))->draft();
        $this->assertEquals('PHP Unit Testing - Success', $frontpage->title());

        settings()->set('seo_position', 'left');

        $frontpage = (new Frontpage($page, new Collection))->draft();
        $this->assertEquals('Success - PHP Unit Testing', $frontpage->title());
    }
}
