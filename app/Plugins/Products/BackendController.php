<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/05/2016
 * Time: 19:32.
 */

namespace App\Plugins\Products;

use App\Plugins\PluginEngine;
use App\Classes\Repositories\PluginRepository;
use App\Classes\Interfaces\InstallableInterface;

/**
 * Class AdminController.
 */
class BackendController extends PluginEngine
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
        return $this->make('index')->with('products', plugins()->all());
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
}
