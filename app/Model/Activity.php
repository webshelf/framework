<?php

namespace App\Model;

use App\Classes\Interfaces\Linker;
use App\Classes\Interfaces\Linkable;
use App\Model\Model;
use App\Classes\Interfaces\Loggable;

use \Spatie\Activitylog\Models\Activity as ActivityLog;

/**
 * Class Activity.
 *
 * @property string $message
 * @property int $event
 *
 * @property Linkable $model
 * @property Account $account
 */
class Activity extends ActivityLog
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity';

}
