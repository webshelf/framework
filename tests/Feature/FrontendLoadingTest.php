<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 02/02/2017
 * Time: 18:38
 */

namespace Tests\Feature;

use Tests\TestCase;

class FrontendLoadingTest extends TestCase
{
    /**
     * @test
     */
    public function view_index_page()
    {
        settings()->add('enable_website', true);

        $this->call('GET', '/')->assertStatus(200)->assertViewHas('page');
    }

    /**
     * @test
     *
     * Does not require website status to show.
     */
    public function view_sitemap_page()
    {
        $this->call('GET', '/sitemap.xml')->assertStatus(200)->assertSee('urlset');
    }

    /**
     * @test
     */
    public function view_404_error_page()
    {
        settings()->add('enable_website', true);

        $this->call('GET', '/unknown-page-test')->assertStatus(404)->assertViewHas('page');
    }

    /**
     * @test
     */
    public function view_503_error_page()
    {
        settings()->add('enable_website', false);

        $this->call('GET', '/')->assertStatus(503) ->assertViewHas('page');
    }
}
