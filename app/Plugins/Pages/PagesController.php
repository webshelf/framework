<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 23/01/2018
 * Time: 15:14.
 */

namespace App\Plugins\Pages;

use App\Plugins\PluginHandler;

/**
 * Class ArticleController.
 */
class PagesController extends PluginHandler
{
    /**
     * Return the icon associated with this plugin.
     */
    public function icon()
    {
        return 'fa-paperclip';
    }

    /**
     * Return the version for this plugin.
     */
    public function version()
    {
        return '2.1';
    }
}
