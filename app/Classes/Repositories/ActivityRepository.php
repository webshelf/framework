<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/09/2016
 * Time: 14:25.
 */

namespace App\Classes\Repositories;

use App\Model\Activity;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ActivityRepository.
 */
class ActivityRepository
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
     * @param Activity $model
     */
    public function __construct(Activity $model)
    {
        $this->model = $model;
    }

    /**
     * Return a collection of all accounts.
     */
    public function all() : Collection
    {
        return $this->model->orderByDesc('created_at')->get();
    }
}
