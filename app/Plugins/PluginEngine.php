<?php

namespace App\Plugins;

use App\Model\Plugin;
use App\Http\Controllers\DashboardController;
use App\Classes\Repositories\PluginRepository;

/**
 * Class PluginEngine.
 */
abstract class PluginEngine extends DashboardController
{
    /**
     * @var
     */
    private $plugin_name;

    /**
     * Return a view that is in the same directory as the plugin.
     *
     * @param $template
     * @return \Illuminate\Contracts\View\View
     * @internal param $blade_template
     */
    protected function blade($template)
    {
        $this->addPluginViewLocation();

        view()->share('plugin', $this->pluginData());

        return $this->view()->make($this->pluginName().'::'.$template);
    }

    /**
     * Redirect to a plugin view location.
     * For ajax return calls.
     *
     * @param $blade_template
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirect($blade_template)
    {
        $this->addPluginViewLocation();

        return redirect()->intended($this->pluginName().'::'.$blade_template);
    }

    /**
     * The the plugins name.
     *
     * @return string
     */
    private function pluginName()
    {
        return $this->plugin_name ?: $this->explodeDirName();
    }

    /**
     * Plugin name by way of the folder, hacky huh ? O>O.
     */
    private function explodeDirName()
    {
        $name = explode('\\', get_class($this));

        return $this->plugin_name = $name['2'];
    }

    /**
     * Add the plugins views to the list of views for loading.
     *
     * No point sorting this as an array since we only visit one place at a time.
     */
    private function addPluginViewLocation()
    {
        view()->addNamespace($this->pluginName(), (__DIR__.'/'.$this->pluginName()));
    }

    protected function pluginData()
    {
        return (new PluginRepository(new Plugin))->whereName($this->pluginName());
    }

    /**
     * Return the self classes method namespaced.
     *
     * @param string $method
     * @return string
     */
    protected function method(string $method)
    {
        return adminPluginController($this->pluginName(), $method);
    }
}
