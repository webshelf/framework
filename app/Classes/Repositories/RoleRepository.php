<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 12/10/2016
 * Time: 20:18.
 */

namespace App\Classes\Repositories;

use App\Model\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleRepository.
 */
class RoleRepository
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
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }

    /**
     * @param int $integer
     * @return Role|array|null|\stdClass
     */
    public function whereID(int $integer) : Role
    {
        return $this->model->where('id', $integer)->first();
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function whereRolesGreaterOrEqualToMyAccount() : \Illuminate\Support\Collection
    {
        return $this->model->where('id', '>=', account()->role->id())->get();
    }
}
