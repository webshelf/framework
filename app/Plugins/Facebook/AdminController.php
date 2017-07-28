<?php

namespace App\Plugins\Facebook;

/*
 * Created by PhpStorm.
 * User: Mark
 * Date: 03/10/2016
 * Time: 21:53
 */

use Illuminate\Routing\Router;
use App\Plugins\PluginEngine;
use App\Classes\Library\Services\Facebook;
use App\Classes\Interfaces\RouteableInterface;

/**
 * Class AdminController.
 */
class AdminController extends PluginEngine implements RouteableInterface
{
    public function index()
    {
        return $this->blade('index')->with('posts', Facebook::loadPostsFrom(settings()->getValue('fb_page_id'), 7))->with('images', Facebook::loadUploadedImagesFrom(settings()->getValue('fb_page_id')));
    }

    /**
     * Routes required for the plugin to operate correctly.
     * These define all available urls that require Auth, or not.
     * These are loaded on application boot time and may be cached.
     *
     * @param \Illuminate\Routing\Router $router
     * @return \Illuminate\Routing\Router
     */
    public function routes(Router $router)
    {
        $router->get('/admin/facebook/', ['as' => 'facebook', 'uses' => adminPluginController('facebook', 'index')]);

        return $router;
    }
}
