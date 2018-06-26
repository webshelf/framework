<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/05/2016
 * Time: 19:32.
 */

namespace App\Plugins\Products;

use App\Model\Plugin;
use App\Plugins\PluginEngine;
use App\Classes\Interfaces\Installable;
use App\Classes\Repositories\PluginRepository;
use App\Plugins\Products\Exceptions\PluginNotInstanceOfInstallable;

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

        $this->middleware(['role:developer']);
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
    public function install(Plugin $plugin)
    {
        if ($plugin->controller instanceof Installable) {
            $plugin->controller->install();

            $plugin->toggle();

            return response()->redirectToRoute('admin.products.index');
        }

        throw new PluginNotInstanceOfInstallable;
    }

    /**
     * Steps required for the application uninstall.
     * Usually defined for logging & new sql entries.
     *
     * @param string $plugin_name
     * @return mixed
     */
    public function uninstall(Plugin $plugin)
    {
        if ($plugin->controller instanceof Installable) {
            $plugin->controller->uninstall();

            $plugin->toggle();

            return response()->redirectToRoute('admin.products.index');
        }

        throw new PluginNotInstanceOfInstallable;
    }
}
