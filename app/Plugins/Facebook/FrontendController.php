<?php

namespace App\Plugins\Facebook;

use App\Classes\Library\Services\Facebook;
use App\Plugins\PluginEngine;

/**
 * Class FrontendController
 *
 * @package App\Plugins\Facebook
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
