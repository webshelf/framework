<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @property int $id
 * @property string $migration
 * @property int batch
 *
 * @property Carbon $created_at
 *
 * Class Migrations.
 */
class Update extends EloquentModel
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
