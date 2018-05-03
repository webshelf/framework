<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 16/02/2018
 * Time: 16:00.
 */

namespace App\Classes\Repositories;

use App\Model\Menu;
use App\Model\Article;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleRepository.
 */
class ArticleRepository extends BaseRepository
{
    /**
     * @var Article|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Article|Menu $model
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
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
        return $this->model->take($count)->where('status', Article::STATUS_PUBLIC)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @ver 5.0.2
     * @date 08/03/2018
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Collection|Collection|static[]
     */
    public function mostViewed($count = 7)
    {
        return $this->model->orderBy('views', 'desc')->take($count)->where('status', Article::STATUS_PUBLIC)->get();
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
        return $this->model->where('status', Article::STATUS_PUBLIC)->get();
    }

    /**
     * @param int $count
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function paginateLatest(int $count)
    {
        return $this->model->orderBy('created_at', 'desc')->where('status', Article::STATUS_PUBLIC)->simplePaginate($count);
    }

    /**
     * @ver 5.1.13
     * @date 19/03/2018
     * @return mixed
     */
    public function activeCategories()
    {
        return app(ArticleCategoryRepository::class)->whereStatusActive();
    }

    /**
     * @ver 5.1.15
     * @date 19/03/2018
     * @param int $creator_id
     * @return int
     */
    public function publishedArticlesCount(int $creator_id)
    {
        return $this->model->where('status', Article::STATUS_PUBLIC)->where('creator_id', $creator_id)->count();
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
        return $this->model->where('slug', $slug)->where('status', Article::STATUS_PUBLIC)->orderBy('created_at', 'desc')->first();
    }

    /**
     * @param string $text
     * @param int $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchThenPaginate(string $text, int $paginate = 7)
    {
        return $this->model->search($text)->orderBy('created_at', 'desc')->where('status', Article::STATUS_PUBLIC)->paginate($paginate);
    }

    public function whereCreatorId(int $creator_id, int $paginate = 5)
    {
        return $this->model->orderBy('created_at', 'desc')->where('creator_id', $creator_id)->where('status', Article::STATUS_PUBLIC)->simplePaginate($paginate);
    }

    public function whereCategoryId(int $id, int $paginate = 5)
    {
        return $this->model->where('category_id', $id)->where('status', Article::STATUS_PUBLIC)->orderBy('created_at', 'desc')->simplePaginate($paginate);
    }
}
