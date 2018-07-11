<?php

namespace App\Modules\Sitemap;

use App\Model\Page;
use App\Model\Article;
use App\Modules\ModuleEngine;
use Illuminate\Http\Response;
use App\Modules\Sitemap\SitemapConstants as Sitemap;

/**
 * Class Controller.
 *
 * Generate the site content sitemap.xml for SEO.
 */
class SitemapController extends ModuleEngine
{
    /**
     * @var SitemapGenerator
     */
    private $sitemap;

    /**
     * Controller constructor.
     *
     * @param SitemapGenerator $sitemap
     */
    public function __construct(SitemapGenerator $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    /**
     * Return a response encoded with xml for sitemap.xml viewing.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        /** @var Page $page */
        foreach (Page::sitemap()->get() as $page) {
            $this->sitemap->add($page->path())->modified($page->updated_at)->withFrequency(Sitemap::FREQUENCY_WEEKLY)->andPriority(Sitemap::PRIORITY_NORMAL);
        }

        /** @var Article $article */
        foreach (Article::all() as $article) {
            $this->sitemap->add($article->path())->modified($article->updated_at)->withFrequency(Sitemap::FREQUENCY_WEEKLY)->andPriority(Sitemap::PRIORITY_NORMAL);
        }

        return response($this->make('sitemap')->with('urlset', $this->sitemap->collection()), 200, ['Content-type' => 'text/xml']);
    }
}
