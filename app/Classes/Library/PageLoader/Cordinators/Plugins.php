<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 19/02/2018
 * Time: 21:28
 */

namespace App\Classes\Library\PageLoader\Cordinators;

use App\Plugins\Articles\ObjectProvider as ArticleObject;

class Plugins
{

    /**
     * @return ArticleObject
     */
    public function articles()
    {
        return app(ArticleObject::class);
    }

}