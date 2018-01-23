<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 23/01/2018
 * Time: 15:14
 */

namespace App\Plugins\Menus;

use App\Plugins\PluginHandler;

/**
 * Class ArticleController
 *
 * @package App\Plugins\Menus
 */
class MenusController extends PluginHandler
{

    /**
     * Return the icon associated with this plugin.
     */
    public function icon()
    {
        return 'fa-bars';
    }

    /**
     * Return the version for this plugin.
     */
    public function version()
    {
        return '2.6';
    }
}