<?php

namespace App\Classes\Repositories;

use App\Model\Menu;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Model\Categories;

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
    public function __construct(Categories $model)
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
