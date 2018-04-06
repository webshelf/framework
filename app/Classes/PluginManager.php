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
     * @var Collection
     */
    private $enabled;

    /**
     * Disabled plugins.
     *
     * @var Collection
     */
    private $disabled;

    /**
     * Viewable by user plugin.
     *
     * @var Collection
     */
    private $viewable;

    /**
     * PluginManager constructor.
     */
    public function __construct()
    {
        $this->enabled = new Collection;

        $this->disabled = new Collection;

        $this->viewable = new Collection;
    }

    /**
     * Add a plugin to the plugin manager for application usage.
     *
     * @param Plugin $plugin
     * @return Collection
     * @throws \Exception
     */
    private function add(Plugin $plugin)
    {
        if ($plugin->enabled == true) {
            if ($plugin->hidden == false) {
                $this->viewable->put($plugin->name, $plugin);
            }

            return $this->enabled->put($plugin->name, $plugin);
        }

        return $this->disabled->put($plugin->name, $plugin);
    }

    /**
     * Return all the application loaded plugins.
     *
     * @return array
     */
    public function all()
    {
        return array_merge($this->enabled->toArray(), $this->disabled->toArray());
    }

    /**
     * Check does the user have the plugin. Boolean.
     *
     * @param $plugin_name
     * @return bool
     */
    public function hasPlugin($plugin_name)
    {
        return $this->enabled->has($plugin_name);
    }

    /**
     * For tenant usage, we must add a collection of settings models from the database.
     *
     * Can be used for anything else though.
     *
     * @param Collection $collection
     * @return $this
     */
    public function loadCollection(Collection $collection)
    {
        /** @var Plugin $model */
        foreach ($collection as $model) {
            $this->add($model);
        }

        return $this;
    }

    /**
     * Enable a plugint hat has been disabled.
     *
     * @param $pluginName
     */
    public function enable($pluginName)
    {
        if ($this->disabled->has($pluginName)) {
            $this->enabled->put($pluginName, $this->disabled->pull($pluginName));
        }
    }

    /**
     * Disable a plugin that has been enabled.
     *
     * @param $pluginName
     */
    public function disable($pluginName)
    {
        if ($this->enabled->has($pluginName)) {
            $this->disabled->put($pluginName, $this->enabled->pull($pluginName));
        }
    }

    /**
     * Return all end user viewable plugins.
     *
     * @return array
     */
    public function getViewable()
    {
        return $this->viewable->all();
    }

    /**
     * Return frameworks enabled plugins.
     *
     * @return array
     */
    public function getEnabled()
    {
        return $this->enabled->all();
    }

    /**
     * Return frameworks disabled plugins.
     *
     * @return array
     */
    public function getDisabled()
    {
        return $this->disabled->all();
    }
}
