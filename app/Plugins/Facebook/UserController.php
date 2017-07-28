<?php

namespace App\Plugins\Facebook;

/*
 * Created by PhpStorm.
 * User: Mark
 * Date: 03/10/2016
 * Time: 21:53
 */
use App\Http\Controllers\Controller;
use App\Classes\Library\Services\Facebook;
use App\Classes\Interfaces\FeedableInterface;

class UserController extends Controller implements FeedableInterface
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
