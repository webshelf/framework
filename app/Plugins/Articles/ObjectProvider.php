<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 19/02/2018
 * Time: 21:26
 */

namespace App\Plugins\Articles;

use App\Classes\Repositories\ArticleCategoryRepository;
use App\Classes\Repositories\ArticleRepository;
use App\Model\Article;
use App\Model\ArticleCategory;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ObjectProvider
 *
 * @package App\Plugins\Articles
 */
class ObjectProvider
{

    /**
     * @var Collection
     */
    public $articles;

    /**
     * @var ArticleRepository
     */
    public $repository;

    /**
     * DataProvider constructor.
     */
    public function __construct()
    {
        $this->repository = app(ArticleRepository::class);

        $this->articles = $this->repository->whereStatusActive();
    }

    public function random(int $count)
    {
        return $this->articles->random($count);
    }

    public function paginate(int $count = 5)
    {
        return $this->repository->paginateLatest($count);
    }

    public function take(int $limit = 5)
    {
        return $this->articles->take($limit)->sortByDesc('created_at');
    }

    public function categories()
    {
        return app(ArticleCategoryRepository::class)->whereStatusActive();
    }

    public function creators()
    {
        return $this->articles->unique('creator_id');
    }

}