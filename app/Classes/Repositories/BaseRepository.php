<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 04/01/2018
 * Time: 00:13.
 */

namespace App\Classes\Repositories;

use App\Model\Menu;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseRepository.
 */
class BaseRepository
{
    /**
     * @var Builder|Collection
     */
    protected $model;

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Get all the articles from the repository in descending order
     *
     * @return mixed
     */
    public function allDescendingOrder()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param int $integer
     * @return Menu
     */
    public function whereID(int $integer)
    {
        return $this->model->where('id', $integer)->first();
    }

    /**
     * @deprecated change to the repository class calling it.
     *
     * @param string $text
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public function whereSlug(string $text)
    {
        return $this->model->where('slug', $text)->first();
    }
}
