<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/05/2016
 * Time: 19:32.
 */

namespace App\Plugins\Products;

use App\Model\Plugin;
use Illuminate\Routing\Router;
use App\Classes\Breadcrumbs;
use App\Plugins\PluginEngine;
use App\Classes\Interfaces\RouteableInterface;
use App\Classes\Repositories\PluginRepository;
use App\Classes\Interfaces\InstallableInterface;

/**
 * Class AdminController.
 */
class AdminController extends PluginEngine implements RouteableInterface
{
    private $products;

    public function __construct(PluginRepository $plugins)
    {
        $this->products = $plugins;
    }

    /**
     * Display a list of products available and disable, enable option for super admins.
     */
    public function index()
    {
        return $this->blade('index')->with('products', plugins()->all());
    }

    /**
     * Change the plugin status from enabled to disabled or vice versa.
     * This will also call the install function on the plugin class if exists.
     *
     * @param $plugin_name
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function ProductStatus($plugin_name)
    {
        $plugin = $this->products->whereName($plugin_name);

        if ($plugin->isEnabled()) {
            $controller = adminPluginController($plugin_name);

            if ($controller instanceof InstallableInterface) {
                $controller->uninstall($plugin);
            }

            $plugin->disable()->save();
        } elseif ($plugin->isDisabled()) {
            $controller = adminPluginController($plugin_name);

            if ($controller instanceof InstallableInterface) {
                $controller->install($plugin);
            }

            $plugin->enable()->save();
        }

        return redirect()->intended(route('ProductIndex'));
    }

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
        $router->get('/admin/products', ['as'=>'ProductIndex', 'uses'=>adminPluginController('products', 'index')]);
        $router->get('/admin/products/{plugin}/status', ['as'=>'ProductStatus', 'uses'=>adminPluginController('products', 'ProductStatus')]);

        return $router;
    }
}
