<?php

namespace App\Model;

use App\Classes\Interfaces\Linkable;
use App\Classes\Interfaces\Linker;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @property string $message
 * @property int $event
 *
 * @property Linkable $model
 * @property Account $account
 *
 * @package App
 */
class Activity extends Model
{

    /**
     * @var int
     */
    public static $deleted = 0;
    /**
     * @var int
     */
    public static $created = 1;
    /**
     * @var int
     */
    public static $updated = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return bool|string
     */
    public function eventName()
    {
        switch ($this->event)
        {
            case self::$deleted : return 'deleted';
            case self::$created : return 'created';
            case self::$updated : return 'updated';
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    /**
     * @return Linker
     */
    public function model()
    {
        return $this->morphTo()->withTrashed();
    }

    /**
     * @param int $action
     * @param Model $model
     * @param Account|null $account
     * @return mixed
     */
    public function log(int $action, Model $model, Account $account = null)
    {
        $this->setAttribute('event', $action);

        $this->setAttribute('model_id', $model->getKey());

        $this->setAttribute('model_type', $model->getMorphClass());

        $this->setAttribute('account_id', $account->getKey());

        return $this->save();
    }
}
