<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 28/10/2016
 * Time: 13:24.
 */

namespace App\Model;

/**
 * Class Permission.
 */
class Permission extends Engine
{
    protected $table = 'permissions';

    // permission codes for application use.
    const ACCESS_SETTINGS = 'access_settings';

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function code()
    {
        return $this->getAttribute('code');
    }

    public function value()
    {
        return $this->getAttribute('value');
    }
}
