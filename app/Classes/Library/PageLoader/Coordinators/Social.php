<?php

namespace App\Classes\Library\PageLoader\Coordinators;

/**
 * Class Social.
 */
class Social
{
    /**
     * @return string
     */
    public function url_youtube()
    {
        return settings()->getDefault('youtube_url');
    }

    /**
     * @return string
     */
    public function url_facebook()
    {
        return settings()->getDefault('facebook_url');
    }

    /**
     * @return string
     */
    public function url_twitter()
    {
        return settings()->getDefault('twitter_url');
    }
}
