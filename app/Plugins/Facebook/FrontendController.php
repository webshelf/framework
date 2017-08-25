<?php

namespace App\Plugins\Facebook;

use App\Plugins\PluginEngine;
use App\Classes\Library\Services\Facebook;

/**
 * Class FrontendController.
 */
class FrontendController extends PluginEngine
{
    /**
     * Feeds if enabled should be sent
     * to the page on every load request.
     *
     * @param $size
     * @return mixed
     */
    public function feed($size)
    {
        if (settings()->getValue('fb_page_id')) {
            return $fb_posts = (new Facebook)->loadPostsFrom(settings()->getValue('fb_page_id'), $size);
        }

        return true;
    }
}
