<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 02/02/2017
 * Time: 18:38
 */

namespace Tests\Feature;

use Tests\TestCase;

class PageLoadingTest extends TestCase
{

    /**
     * @test
     */
    public function homepage_should_be_viewable()
    {
        settings()->add('enable_website', true);

        $this->call('GET', '/')
            ->assertSee('/')
            ->assertStatus(200)
            ->assertViewHas('page');

        $this->assertDatabaseHas('pages', ['slug' => 'index']);
        $this->assertDatabaseHas('menus', ['slug' => 'index']);
    }

    /**
     * @test
     */
    public function unknown_pages_are_handled_by_404()
    {
        settings()->add('enable_website', true);

        $this->call('GET', '/unknown-page-test')
            ->assertStatus(404)
            ->assertViewHas('page');
    }

    /**
     * @test
     */
    public function maintenance_pages_are_handled_by_503()
    {
        settings()->add('enable_website', false);

        $this->call('GET', '/')
            ->assertStatus(503)
            ->assertViewHas('page');
    }

    /**
     * @test
     */
    public function sitemap_xml_should_always_be_viewable()
    {
        $this->call('GET', '/sitemap.xml')
            ->assertStatus(200)
            ->assertSee('urlset');
    }
    
    /**
     * @test
     */
    public function dashboard_should_redirect_to_login()
    {
        $this->call('GET', '/admin')
            ->assertStatus(302)
            ->assertSee('/admin/login')
            ->assertSee('Redirecting');
    }
}
