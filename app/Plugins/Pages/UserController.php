<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\Pages;

use App\Model\Page;
use Illuminate\Routing\Router;
use App\Classes\SitemapGenerator;
use App\Classes\Repositories\PageRepository;
use App\Classes\Interfaces\RouteableInterface;
use App\Classes\Interfaces\SitemappableInterface;

/**
 * Class UserController.
 */
class UserController implements RouteableInterface, SitemappableInterface
{
    /**
     * @var PageRepository
     */
    private $pages;

    /**
     * UserController constructor.
     *
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Routes required for the plugin to operate correctly.
     * These define all available urls that require Auth, or not.
     * These are loaded on application boot time and may be cached.
     *
     * If the page is a plugin we will load its plugin folder and its index method
     * If its a normal page we will send it to the page controller for page loading and viewing.
     *
     * @param Router $router
     * @return Router|void
     */
    public function routes(Router $router)
    {
        /** @var Page $page */
        foreach ($this->pages->allWithMenuAndParent() as $page) {
            if (! $page->redirect) {
                if ($page->isPlugin()) {
                    $router->get(makeSlug($page))->name($page->slug())->uses(userPluginController($page->slug(), 'index'));
                } else {
                    $router->get(makeSlug($page))->name($page->slug())->uses('App\Http\Controllers\PageController@view');
                }
            }
        }
    }

    /**
     * The sitemap function allows plugins to quickly and effectively
     * create and store new content for the SEO Sitemap Controller.
     *
     * @param SitemapGenerator $sitemap
     * @return SitemapGenerator
     */
    public function sitemap(SitemapGenerator $sitemap)
    {
        /** @var Page $page */
        foreach ($this->pages->whereSitemap() as $page) {
            $sitemap->store(makeUrl($page), $page->updatedAt(), 'daily', '1.0');
        }

        return $sitemap;
    }
}
