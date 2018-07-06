<?php

namespace App\Modules\Sitemap;

use App\Modules\ModuleEngine;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;

/**
 * Class Controller.
 *
 * Generate the site content sitemap.xml for SEO.
 */
class Controller extends ModuleEngine
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
}
