<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/05/2016
 * Time: 22:27.
 */

namespace App\Plugins\Menus;

use Illuminate\Routing\Router;
use App\Classes\SitemapGenerator;
use App\Classes\Interfaces\RouteableInterface;
use App\Classes\Interfaces\SitemappableInterface;

/**
 * Class UserController.
 */
class UserController implements RouteableInterface, SitemappableInterface
{
    /**
     * Routes required for the plugin to operate correctly.
     * These define all available urls that require Auth, or not.
     * These are loaded on application boot time and may be cached.
     *
     * @param Router $router
     * @return mixed
     */
    public function routes(Router $router)
    {
        return $router;
    }

    /**
     * The sitemap function allows plugins to quickly and effectively
     * create and store new content for the SEO Sitemap Controller.
     *
     * @param SitemapGenerator $sitemap
     * @return mixed
     */
    public function sitemap(SitemapGenerator $sitemap)
    {
        return $sitemap;
    }
}
