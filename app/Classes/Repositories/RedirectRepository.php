<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/07/2016
 * Time: 20:37.
 */

namespace App\Classes\Repositories;

use App\Model\Redirect;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RedirectRepository.
 */
class RedirectRepository
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
     * @param Redirect $model
     */
    public function __construct(Redirect $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }

    /**
     * @param int $integer
     * @return Redirect|array|\stdClass
     */
    public function whereID(int $integer) : Redirect
    {
        return $this->model->where('id', $integer)->first();
    }
}
