<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/03/2016
 * Time: 21:46.
 */

namespace App\Classes\Repositories;

use App\Model\Migration;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DalmRepository.
 */
class MigrationRepository
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
     * @param Migration $model
     */
    public function __construct(Migration $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }
}
