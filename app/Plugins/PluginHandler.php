<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 23/01/2018
 * Time: 14:23.
 */

namespace App\Plugins;

/**
 * Class PluginHandler.
 */
abstract class PluginHandler extends PluginEngine
{
    /**
     * Return the icon display for this plugin.
     *
     * @return string
     */
    abstract public function icon();

    /**
     * Returns the version identifier.
     *
     * @return string
     */
    abstract public function version();
}
