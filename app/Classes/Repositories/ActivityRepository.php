<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 19/01/2018
 * Time: 23:48.
 */

namespace App\Classes\Repositories;

use App\Model\Activity;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ActivityRepository.
 */
class ActivityRepository extends BaseRepository
{
    /**
     * @var Activity|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Activity $model
     */
    public function __construct(Activity $model)
    {
        $this->model = $model;
    }

    public function paginate($count = 25)
    {
        return $this->model->orderByDesc('created_at')->paginate($count);
    }
}
