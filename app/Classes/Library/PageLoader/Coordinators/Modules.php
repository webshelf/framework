<?php

namespace App\Classes\Library\PageLoader\Coordinators;

use App\Model\Article;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Plugins.
 */
class Modules
{
    /**
     * @var Collection
     */
    public $articles;

    /**
     * Returned a scope collection for use frontend.
     * This allows us to perform only one query to collect
     * the articles.
     *
     * @return Collection
     */
    public function articles()
    {
        return $this->articles ?? $this->articles = Article::where('status', true)->get();
    }
}
