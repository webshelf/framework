<?php

namespace App\Model;

use Spatie\Permission\Models\Role as BaseRoles;

/**
 * Class Migrations.
 *
 * @property string $name
 * @property string $title
 * @property string $description
 */
class Role extends BaseRoles
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
}
