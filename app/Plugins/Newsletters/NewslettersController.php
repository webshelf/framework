<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 23/01/2018
 * Time: 15:14.
 */

namespace App\Plugins\Newsletters;

use App\Plugins\PluginHandler;
use App\Classes\Interfaces\Installable;

/**
 * Class NewsletterController.
 */
class NewslettersController extends PluginHandler implements Installable
{
    /**
     * Return the icon associated with this plugin.
     */
    public function icon()
    {
        return 'fa-book';
    }

    /**
     * Return the version for this plugin.
     */
    public function version()
    {
        return '1.0';
    }

    /**
     * The steps required for this plugin product to fully
     * integrate into the webservice.
     *
     * @return bool
     */
    public function install()
    {
        // TODO: Implement install() method.
    }

    /**
     * The steps required for this plugin product to fully
     * remove itself from the webservice.
     *
     * @return bool
     */
    public function uninstall()
    {
        // TODO: Implement uninstall() method.
    }
}
