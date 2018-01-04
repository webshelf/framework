<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/08/2017
 * Time: 16:22.
 */

namespace App\Classes\Repositories;

use App\Model\Audit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class AuditRepository.
 */
class AuditRepository extends BaseRepository
{
    /**
     * @var Audit|Builder|Collection
     */
    protected $model;

    /**
     * PageRepository constructor.
     *
     * @param Audit $model
     */
    public function __construct(Audit $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $count
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateAudits($count = 15)
    {
        return $this->model->orderByDesc('created_at')->paginate($count);
    }
}
