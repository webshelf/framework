<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/05/2016
 * Time: 19:32.
 */

namespace App\Plugins\Products;

use App\Plugins\PluginEngine;
use App\Classes\Interfaces\Installable;
use App\Classes\Repositories\PluginRepository;

/**
 * Class AdminController.
 */
class BackendController extends PluginEngine
{
    /**
     * @var PluginRepository
     */
    private $plugins;

    /**
     * BackendController constructor.
     * @param PluginRepository $plugins
     */
    public function __construct(PluginRepository $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * Display a list of products available and disable, enable option for super admins.
     */
    public function index()
    {
        return $this->make('index')->with('products', $this->plugins->all());
    }

    /**
     * Steps required for the application install.
     * Usually defined for logging & new sql entries.
     *
     * @param string $plugin_name
     * @return mixed
     */
    public function install(string $plugin_name)
    {
        $plugin = $this->plugins->whereName($plugin_name);

        if ($plugin->enabled == false) {
            \DB::transaction(function () use ($plugin) {
                if ($plugin->handler instanceof Installable) {
                    $plugin->handler->install();
                }

                $plugin->enabled = true;

                $plugin->save();
            }, 5);
        }

        return response()->redirectToRoute('products.index');
    }

    /**
     * Steps required for the application uninstall.
     * Usually defined for logging & new sql entries.
     *
     * @param string $plugin_name
     * @return mixed
     */
    public function uninstall(string $plugin_name)
    {
        $plugin = $this->plugins->whereName($plugin_name);

        if ($plugin->enabled == true) {
            \DB::transaction(function () use ($plugin) {
                if ($plugin->handler instanceof Installable) {
                    $plugin->handler->uninstall();
                }

                $plugin->enabled = false;

                $plugin->save();
            }, 5);
        }

        return response()->redirectToRoute('products.index');
    }
}
