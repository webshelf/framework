<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 04/01/2018
 * Time: 01:33
 */

namespace Tests\Unit;

use App\Classes\Breadcrumbs;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Class BreadcrumbsTest
 *
 * @package Tests\Unit
 */
class BreadcrumbsTest extends TestCase
{

    public function testAddCrumb()
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = app(Breadcrumbs::class);

        $breadcrumbs->addCrumb('Home', 'http://website.com');

        $this->assertCount(1, $breadcrumbs->crumbs());
    }

    public function testContainsWithFilterMatchingCase()
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = app(Breadcrumbs::class);

        $breadcrumbs->addCrumb('Home', 'http://website.com');

        $this->assertTrue($breadcrumbs->contain('Home', 0));
    }

    public function testContainsWithFilterLowercase()
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = app(Breadcrumbs::class);

        $breadcrumbs->addCrumb('Home', 'http://website.com');

        $this->assertTrue($breadcrumbs->contain('home', 0));
    }

    public function testInvalidContainValue()
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = app(Breadcrumbs::class);

        $breadcrumbs->addCrumb('Home', 'http://website.com');

        $this->assertfalse($breadcrumbs->contain('not-valid-title', 5));
    }

    public function testCrumbCounting()
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = app(Breadcrumbs::class);

        $breadcrumbs->addCrumb('Home', 'http://website.com');

        $this->assertTrue($breadcrumbs->hasCount(1));
    }

    public function testFromCurrentRoute()
    {
        Route::get('/breadcrumb/test', function () {
            return 'Hello World';
        });

        $this->call('GET', '/breadcrumb/test');

        $this->assertCount(3, Breadcrumbs::fromCurrentRoute()->crumbs());
    }

    // @todo: Check the array for the correct return string.?
}
