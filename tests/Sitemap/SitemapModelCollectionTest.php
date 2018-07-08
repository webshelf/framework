<?php

namespace Tests\Sitemap;

use App\Model\Page;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SitemapModelCollectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_collect_pages()
    {
        factory('App\Model\Page', 3)->create();

        dd(Page::all());
    }
}
