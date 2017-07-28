<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 08/01/2017
 * Time: 00:32.
 */

namespace App\Plugins\Carousels;

use App\Classes\Interfaces\FeedableInterface;

/**
 * Class UserController.
 */
class UserController implements FeedableInterface
{
    /**
     * Feeds are data that will be attached to a page loading
     * This data is then cached for faster loading.
     *
     * TFeeds are controlled using the PluginFeed Model.
     *
     * @param  $size
     * @return mixed|void
     */
    public function feed($size)
    {
        // TODO: Implement feed() method.
    }
}
