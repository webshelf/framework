<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/01/2017
 * Time: 03:33.
 */

namespace App\Http\Middleware;

use Closure;
use App\Model\Plugin;
use Illuminate\Routing\Router;
use App\Classes\Interfaces\RouteableInterface;

/**
 * Class SettingsProvider.
 */
class RouteProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $router = app('router');

        /** @var Plugin $plugin */
        foreach (plugins()->all() as $plugin) {
            // does not require authentication.
            if ($plugin->isFrontEnd() && userPluginController($plugin->name()) instanceof RouteableInterface) {
                $this->loadPluginRoutes(userPluginController($plugin->name(), null, false), $router);
            }

            // requires authentication
            if ($plugin->isBackEnd() && adminPluginController($plugin->name()) instanceof RouteableInterface) {
                $this->loadPluginRoutes(adminPluginController($plugin->name(), null, false), $router);
            }
        }

        return $next($request);
    }

    /**
     * Load the plugin controller route method.
     * Since plugin routes need to exist on boot.
     * For people to use no matter what page they
     * are in.
     *
     * @param RouteableInterface $plugin
     * @param Router $withRouter
     */
    private function loadPluginRoutes(RouteableInterface $plugin, Router $withRouter)
    {
        $plugin->routes($withRouter);
    }
}
