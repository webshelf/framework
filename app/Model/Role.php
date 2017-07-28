<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/08/2016
 * Time: 13:45.
 */

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role.
 */
class Role extends Engine
{
    use SoftDeletes;

    protected $table = 'roles';

    // DEFINE VALUES FOR ROLES.
    const SUPERUSER = 1;
    const ADMINISTRATOR = 2;
    const CONTENT_CREATOR = 3;

    protected $softDeletes = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function id()
    {
        return $this->getAttribute('id');
    }

    public function title()
    {
        return $this->getAttribute('title');
    }

    public function setTitle($string)
    {
        $this->setAttribute('title', $string);

        return $this;
    }

    public function description()
    {
        return $this->getAttribute('description');
    }

    public function setDescription($string)
    {
        $this->setAttribute('description', $string);

        return $this;
    }

    public function updatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    public function createdAt()
    {
        return $this->getAttribute('created_at');
    }

    public function deletedAt()
    {
        return $this->getAttribute('deleted_at');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_id', 'id');
    }
}
