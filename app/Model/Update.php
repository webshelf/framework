<?php

namespace App\Model;

use Carbon\Carbon;
use App\Model\Model;

/**
 * @property int $id
 * @property string $migration
 * @property int batch
 *
 * @property Carbon $created_at
 *
 * Class Migrations.
 */
class Update extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'updates';

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at'];
}
