<?php

namespace App\Plugins\Facebook;

use App\Plugins\PluginEngine;
use App\Classes\Library\Services\Facebook;

/**
 * Class BackendController.
 */
class BackendController extends PluginEngine
{
    public function index()
    {
        return $this->make('index')->with('posts', Facebook::loadPostsFrom(settings()->getValue('fb_page_id'), 7))->with('images', Facebook::loadUploadedImagesFrom(settings()->getValue('fb_page_id')));
    }
}
