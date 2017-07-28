<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 30/05/2016
 * Time: 15:29.
 */

namespace App\Classes\Interfaces;

/**
 * Interface FeedableInterface.
 */
interface FeedableInterface
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
    public function feed($size);
}
