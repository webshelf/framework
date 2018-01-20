<?php

namespace App\Model;

use App\Classes\Interfaces\Linker;
use Illuminate\Support\Collection;
use App\Classes\Interfaces\Linkable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Link.
 *
 * @property string $external
 *
 * @property Linkable $to
 */
class Link extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'links';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table date columns, casted to Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|Collection
     */
    public function from()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|Collection|Linkable
     */
    public function to()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function url()
    {
        if ($this->isExternal()) {
            return $this->external;
        }

        return $this->to->route();
    }

    /**
     * @return bool
     */
    public function isExternal()
    {
        return $this->external ? true : false;
    }

    /**
     * @param Linker $model
     * @param Linkable|null $object
     * @param string $external
     * @return $this
     */
    public function connect(Linker $model, Linkable $object = null, string $external = '')
    {
        if ($model && $object) {
            $this->setAttribute('from_id', $model->getKey());

            $this->setAttribute('from_type', $model->getMorphClass());

            $this->setAttribute('to_id', $object->getKey());

            $this->setAttribute('to_type', $object->getMorphClass());

            return $this;
        }

        if ($model && $external) {
            $this->setAttribute('from_id', $model->getKey());

            $this->setAttribute('from_type', $model->getMorphClass());

            $this->setAttribute('external', $external);

            return $this;
        }
    }
}
