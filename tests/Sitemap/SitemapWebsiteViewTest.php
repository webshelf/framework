<?php

namespace Tests\Sitemap;

use Tests\TestCase;

class SitemapWebsiteViewTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_display_the_sitemap_at_sitemap_xml()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertSessionHas('sitemap')->assertOk();
    }
}
