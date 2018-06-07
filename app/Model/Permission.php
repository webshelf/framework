<?php

namespace App\Model;

use Spatie\Permission\Models\Permission as BasePermissions;

/**
 * Class Migrations.
 */
class Permission extends BasePermissions
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';
}
