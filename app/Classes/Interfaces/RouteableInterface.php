<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 08/03/2016
 * Time: 11:02.
 */

namespace App\Classes\Interfaces;

use Illuminate\Routing\Router;

/**
 * Interface PluginCodeInterface.
 */
interface RouteableInterface
{
    /**
     * Routes required for the plugin to operate correctly.
     * These define all available urls that require Auth, or not.
     * These are loaded on application boot time and may be cached.
     *
     * @param Router $router
     * @return Router|void
     */
    public function routes(Router $router);
}
