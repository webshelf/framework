<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 04/01/2018
 * Time: 00:13
 */

namespace App\Classes\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Class BaseRepository
 *
 * @package App\Classes\Repositories
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
     * @param int $integer
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function whereID(int $integer)
    {
        return $this->model->where('id', $integer)->first();
    }

}