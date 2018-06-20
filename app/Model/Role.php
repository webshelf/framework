<?php

namespace App\Model;

use App\Model\Model;

/**
 * Class Migrations.
 *
 * @property string $name
 * @property string $title
 * @property string $description
 */
class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'system_roles';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
