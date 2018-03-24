<?php

namespace App\Classes\Repositories;

use App\Model\Menu;
use App\Model\ArticleCategory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleCategoryRepository.
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
