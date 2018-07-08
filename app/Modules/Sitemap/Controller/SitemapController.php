<?php

namespace App\Modules\Sitemap\Controller;

use App\Modules\ModuleEngine;
use Illuminate\Http\Response;
use App\Modules\Sitemap\SitemapGenerator;

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
        return response($this->make('sitemap'), 200, ['Content-type' => 'text/xml']);
    }
}
