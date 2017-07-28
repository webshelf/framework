<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 18/12/2016
 * Time: 15:52.
 */

namespace App\Classes\Library\Services;

use Cache;
use Facebook\Facebook as FacebookAPI;

/**
 * Class Facebook.
 */
class Facebook
{
    // we will define our own applications facebook profile
    // that will be used to access the tenants profile.
    const app_id = '661838800646818';
    const app_token = '661838800646818|DO2i4mkW6M3SnPFwRvTKvDNy7XE';
    const app_secret = 'ce7263ad725533756335d40cdfc6263f';
    const app_version = 'v2.8';

    /**
     * @var self
     */
    private static $instance;

    /**
     * Construct the facebook api service by providing it with the details from
     * our applications profile page created with facebook dev tools.
     */
    public static function class()
    {
        return self::$instance ?? new FacebookAPI(['app_id'=>static::app_id, 'app_secret'=>static::app_secret, 'default_graph_version'=>static::app_version, 'default_access_token'=>static::app_token]);
    }

    /**
     * Return all the public posts from the facebook page id with access from our pplications profile.
     */
    public static function loadPostsFrom(string $facebook_page_id, int $limit = 7) : array
    {
        return Cache::remember("{$facebook_page_id}_posts", 60, function () use ($facebook_page_id, $limit) {
            return self::class()->get("/{$facebook_page_id}/posts?fields=attachments,message,created_time,from,icon&limit={$limit}")->getGraphEdge()->asArray();
        });
    }

    /**
     * Sometimes we require the latest new from facebook for usage on our news plugin, this is the method.
     */
    public static function loadFeedWithAttachmentsFrom(string $facebook_id, int $limit = 7) : array
    {
        return self::class()->get("{$facebook_id}/posts?fields=attachments,message,created_time,from,icon&limit={$limit}")->getGraphEdge()->asArray();
    }

    /**
     * Sometimes we required the latest uploaded images for example display on a gallery.
     */
    public static function loadUploadedImagesFrom(string $facebook_id, int $limit = 7) : array
    {
        return self::class()->get("{$facebook_id}/photos?fields=from,link,created_time,icon,album&type=uploaded&limit={$limit}")->getGraphEdge()->asArray();
    }
}
