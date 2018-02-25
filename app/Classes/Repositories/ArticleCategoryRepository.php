<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 17/02/2018
 * Time: 23:04
 */

namespace App\Classes\Repositories;

use App\Model\Article;
use App\Model\Menu;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Model\ArticleCategory;

/**
 * Class ArticleCategoryRepository
 *
 * @package App\Classes\Repositories
 */
class ArticleCategoryRepository extends BaseRepository
{
    /**
     * @var ArticleCategory|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Menu $model
     */
    public function __construct(ArticleCategory $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function whereStatusActive()
    {
        return $this->model->where('status', true)->get();
    }
}