<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 20/04/2016
 * Time: 13:05.
 */

namespace App\Classes\Repositories;

use App\Model\Article;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class NewsRepository.
 */
class ArticleRepository
{
    /**
     * The model for eloquent access.
     *
     * @var Builder
     */
    private $model;

    /**
     * AccountRepository constructor.
     *
     * @param Article $model
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * Return a collection of all accounts.
     */
    public function all() : Collection
    {
        return $this->model->get();
    }

    /**
     * @param int $integer
     * @return mixed
     */
    public function paginateEnabled($integer = 7)
    {
        return $this->model->where('publish', true)->paginate($integer);
    }

    /**
     * @param $string
     * @return Article
     */
    public function whereSlug($string) : Article
    {
        return $this->model->where('slug', $string)->first();
    }
}
