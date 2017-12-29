<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\Pages;

use App\Model\Page;
use App\Plugins\PluginEngine;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\Sitemap;
use App\Classes\Repositories\PageRepository;

/**
 * Class UserController.
 */
class FrontendController extends PluginEngine implements Sitemap
{
    /**
     * The sitemap function allows plugins to quickly and effectively
     * create and store new content for the SEO Sitemap Controller.
     *
     * @param SitemapGenerator $sitemap
     * @return SitemapGenerator
     */
    public function sitemap(SitemapGenerator $sitemap)
    {
        /** @var PageRepository $repository */
        $repository = app(PageRepository::class);

        /** @var Page $page */
        foreach ($repository->whereSitemap() as $page) {
            $sitemap->store($page->url, $page->updated_at, 'daily', '1.0');
        }

        return $sitemap;
    }
}
