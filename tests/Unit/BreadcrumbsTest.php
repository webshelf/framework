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

        $this->assertCount(1, $breadcrumbs->make());
    }

    public function testfromCurrentRoute()
    {
        Route::get('/breadcrumb/test', function () {
            return 'Hello World';
        });

        $this->call('GET', '/breadcrumb/test');

        $this->assertCount(3, Breadcrumbs::fromCurrentRoute());
    }

    // @todo: Check the array for the correct return string.?
}
