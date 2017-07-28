<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 24/05/2016
 * Time: 16:30.
 */

namespace App\Classes\Interfaces;

use App\Model\Plugin;

/**
 * Interface InstallableInterface.
 *
 * Plugins require an installable interface for initiating first use setup.
 */
interface InstallableInterface
{
    /**
     * Steps required for the application install.
     * Usually defined for logging & new sql entries.
     *
     * @param Plugin $plugin
     * @return mixed
     */
    public function install(Plugin $plugin);

    /**
     * Steps required for the application uninstall.
     * Usually defined for logging & new sql entries.
     *
     * @param Plugin $plugin
     * @return mixed
     */
    public function uninstall(Plugin $plugin);
}
