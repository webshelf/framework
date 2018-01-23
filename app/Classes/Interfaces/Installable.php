<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 24/05/2016
 * Time: 16:30.
 */

namespace App\Classes\Interfaces;

/**
 * Interface InstallableInterface.
 *
 * Plugins require an installable interface for initiating first use setup.
 */
interface Installable
{
    /**
     * The steps required for this plugin product to fully
     * integrate into the webservice.
     *
     * @return boolean
     */
    public function install();

    /**
     * The steps required for this plugin product to fully
     * remove itself from the webservice.
     *
     * @return boolean
     */
    public function uninstall();
}
