<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/07/2016
 * Time: 18:49.
 */

namespace App\Classes;

use App\Model\Plugin;
use Illuminate\Support\Collection;

/**
 * Class PluginManager.
 */
class PluginManager
{
    /**
     * Enabled plugins.
     *
     * @var array
     */
    private $enabled = [];

    /**
     * Disabled plugins.
     *
     * @var array
     */
    private $disabled = [];

    /**
     * Viewable by user plugin.
     *
     * @var array
     */
    private $viewable = [];

    /**
     * Add a plugin to the plugin manager for application usage.
     *
     * @param Plugin $plugin
     * @return $this
     * @throws \Exception
     */
    public function add(Plugin $plugin)
    {
        if ($plugin->isEnabled()) {
            // set as a viewable plugin
            if ($plugin->isHidden() == false) {
                $this->viewable[$plugin->name()] = $plugin;
            }

            // add to enabled plugins.
            $this->enabled[$plugin->name()] = $plugin;
        } else {
            $this->disabled[$plugin->name()] = $plugin;
        }

        return $this;
    }

    /**
     * Return all the application loaded plugins.
     *
     * @return array
     */
    public function all()
    {
        return array_merge($this->enabled, $this->disabled);
    }

    /**
     * Check if the plugins is enabled (boolean)
     * or return all enabled plugins by default.
     *
     * @param null $plugin
     * @return array|bool
     */
    public function enabled($plugin = null)
    {
        if ($plugin != null) {
            return $this->checkStatus($this->getPlugin($plugin), true);
        }

        return $this->enabled;
    }

    /**
     * Check if the plugin is disabled (boolean)
     * Or return all disabled plugins by default.
     *
     * @param null $plugin
     * @return array|bool
     */
    public function disabled($plugin = null)
    {
        if ($plugin != null) {
            return $this->checkStatus($this->getPlugin($plugin), false);
        }

        return $this->disabled;
    }

    /**
     * Check does the user have the plugin. Boolean.
     *
     * @param $plugin_name
     * @return bool
     */
    public function hasPlugin($plugin_name)
    {
        return array_key_exists($plugin_name, $this->enabled);
    }

    /**
     * Get the loaded plugin from the array.
     *
     * @param $plugin_name
     * @return mixed
     * @throws \Exception
     */
    private function getPlugin($plugin_name)
    {
        if (array_key_exists($plugin_name, $this->all())) {
            return $this->all()[$plugin_name];
        }

        throw new \Exception(sprintf('Cannot load the plugin (%s) as it does not exist.', $plugin_name));
    }

    /**
     * Check the status of a loaded plugin.
     *
     * @param array $plugin
     * @param $status
     * @return bool
     */
    private function checkStatus($plugin, $status)
    {
        return $plugin['enabled'] == $status;
    }

    /**
     * For tenant usage, we must add a collection of settings models from the database.
     *
     * Can be used for anything else though.
     *
     * @param Collection $collection
     * @return $this
     */
    public function collect(Collection $collection)
    {
        /** @var Plugin $model */
        foreach ($collection as $model) {
            $this->add($model);
        }

        return $this;
    }

    /**
     * Check if plugin is viewable (booleans)
     * or return all viewable plugins by default.
     *
     * @param null $plugin
     * @return array|bool
     */
    public function viewable($plugin = null)
    {
        if ($plugin != null) {
            return $this->checkViewable($this->getPlugin($plugin), true);
        }

        return $this->viewable;
    }
}
