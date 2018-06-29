<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 23/01/2018
 * Time: 15:14.
 */

namespace App\Plugins\Redirects;

use App\Plugins\PluginHandler;

/**
 * Class ArticleController.
 */
class RedirectsController extends PluginHandler
{
    /**
     * Return the icon associated with this plugin.
     */
    public function icon()
    {
        return 'fas fa-exchange-alt';
    }

    /**
     * Return the version for this plugin.
     */
    public function version()
    {
        return '1.9';
    }
}
