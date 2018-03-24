<?php

namespace App\Classes\Library\PageLoader\Coordinators;

use App\Classes\Repositories\ArticleRepository;

/**
 * Class Plugins.
 */
class Plugins
{
    /**
     * @var ArticleRepository
     */
    public $articles;

    /**
     * Plugins constructor.
     */
    public function __construct()
    {
        $this->articles = app(ArticleRepository::class);
    }
}
