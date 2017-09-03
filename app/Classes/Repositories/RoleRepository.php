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
class RoleRepository extends Role
{

    /**
     * @param int $integer
     * @return Role|array|null|\stdClass
     */
    public function whereID(int $integer)
    {
        return $this->where('id', $integer)->first();
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function whereRolesGreaterOrEqualToMyAccount()
    {
        return $this->where('id', '>=', account()->role->id)->get();
    }
}
