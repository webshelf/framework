<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Classes\Breadcrumbs;

/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 14/09/2016
 * Time: 16:14
 */
class BreadcrumbsTest extends TestCase
{

    /**
     * @test
     */
    public function test_breadcrumbs_match_expected_crumb_size()
    {
        // Setup the breadcrumb class for testing.
        $breadcrumbs_a = new Breadcrumbs();
        $breadcrumbs_b = new Breadcrumbs();

        // Check if the breadcrumbs assert a true count of three based on the url.
        $this->assertCount(3, $breadcrumbs_a->fromAbsoluteUrl('http://domain.com/example/crumbs')->crumbs());

        // Check if the breadcrumbs show a true count of 2 when the home crumb is removed.
        $this->assertCount(2, $breadcrumbs_b->fromAbsoluteUrl('http://domain.com/example/crumbs')->remove(['home'])->crumbs());
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function test_duplicate_breadcrumb_generation()
    {
        $breadcrumbs = new Breadcrumbs();

        $breadcrumbs->fromAbsoluteUrl('http://domain.com/admin/');
        $breadcrumbs->fromAbsoluteUrl('http://domain.com/example/crumbs');
    }

    /**
     * @test
     */
    public function test_breadcrumbs_can_check_if_contains()
    {
        $breadcrumbs = new Breadcrumbs();

        $breadcrumbs->fromAbsoluteUrl('http://domain.com/example/crumbs/duplicate/example');

        $this->assertTrue ($breadcrumbs->contain('example'));
        $this->assertTrue ($breadcrumbs->contain('crumbs', 3));
        $this->assertFalse($breadcrumbs->contain('example', 3));
    }

    /**
     * @test
     */
    public function test_breadcrumbs_can_be_removed()
    {
        $breadcrumbs = new Breadcrumbs();

        $breadcrumbs->fromAbsoluteUrl('http://example.com/admin/test')->remove(['admin']);

        $this->assertCount(2, $breadcrumbs->crumbs());
    }

    /**
     * @test
     */
    public function test_crumb_names_can_be_altered()
    {
        $breadcrumbs = new Breadcrumbs();

        $breadcrumbs->fromAbsoluteUrl('http://example.com/admin/test')->rename(['home' => 'dashboard']);

        $this->assertTrue($breadcrumbs->contain('home'));
        $this->assertCount(3, $breadcrumbs->crumbs());
    }
}
