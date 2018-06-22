<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 16/02/2018
 * Time: 16:00.
 */

namespace App\Classes\Repositories;

use App\Model\Menu;
use Illuminate\Support\Collection;
use App\Plugins\Articles\Model\Article;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleRepository.
 */
class ArticleRepository extends BaseRepository
{
    /**
     * @var model|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param model|Menu $model
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * Retrive all the available model for administration use.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->withoutGlobalScope('public')->all();
    }

    public function whereSitemappable()
    {
        return $this->model->where(['sitemap' => true, 'status' => true])->get();
    }

    /**
     * @ver 5.0.2
     * @date 08/03/2018
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Collection|Collection|static[]
     */
    public function latest($count = 7)
    {
        return $this->model->take($count)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @ver 5.0.2
     * @date 08/03/2018
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Collection|Collection|static[]
     */
    public function mostViewed($count = 7)
    {
        return $this->model->orderBy('views', 'desc')->take($count)->get();
    }

    /**
     * @ver 5.1.13
     * @date 19/03/2018
     * @return mixed
     */
    public function uniqueCreators()
    {
        return $this->model->all()->unique('creator_id');
    }

    /**
     * @ver 5.1.14
     * @date 19/03/2018
     * @return mixed
     */
    public function viewable()
    {
        return $this->model->where('status', model::STATUS_PUBLIC)->get();
    }

    /**
     * @param int $count
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function paginateLatest(int $count)
    {
        return $this->model->orderBy('created_at', 'desc')->simplePaginate($count);
    }

    /**
     * @ver 5.1.13
     * @date 19/03/2018
     * @return mixed
     */
    public function activeCategories()
    {
        return app(modelCategoryRepository::class)->whereStatusActive();
    }

    /**
     * @ver 5.1.15
     * @date 19/03/2018
     * @param int $creator_id
     * @return int
     */
    public function publishedmodelCount(int $creator_id)
    {
        return $this->model->where('creator_id', $creator_id)->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function whereStatusActive()
    {
        return $this->model->where('status', true)->get();
    }

    public function collectArticle(string $slug)
    {
        return $this->model->where('slug', $slug)->orderBy('created_at', 'desc')->first();
    }

    public function whereCreatorId(int $creator_id, int $paginate = 5)
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->where('creator_id', $creator_id)
            ->simplePaginate($paginate);
    }

    /**
     * Undocumented function.
     *
     * @param string $string
     * @param int $paginate
     * @return void
     */
    public function whereCategoryTitle(string $string, int $paginate = 5)
    {
        return $this->model->whereHas('category', function ($query) {
            $query->where('title', 'general');
        })->orderBy('created_at', 'desc')->simplePaginate($paginate);
    }
}
