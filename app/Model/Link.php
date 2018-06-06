<?php

namespace App\Model;

use App\Classes\Interfaces\Linker;
use Illuminate\Support\Collection;
use App\Classes\Interfaces\Linkable;
use App\Model\Model;

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
     * Return the link URL based on the condition of it being internal or externally
     * based.
     *
     * @return void
     */
    public function url()
    {
        if ($this->isExternal()) {
            return $this->external;
        }

        return $this->to->route();
    }

    /**
     * Is the current model external or internally linked.
     *
     * @return bool
     */
    public function isExternal()
    {
        return $this->external ? true : false;
    }

    /**
     * Disconnect a resource from its linked resource.
     *
     * @return void
     */
    public function disconnect()
    {
        $this->setAttribute('to_id', null);
        $this->setAttribute('to_type', null);
        $this->setAttribute('external', '#');

        return $this->save();
    }

    /**
     * Link two internal resources together using the linker model (url).
     *
     * @param Linker $model
     * @param Linkable $object
     * @return Link
     */
    public function model(Linker $model, Linkable $object)
    {
        $this->updateOrCreate(
            ['from_id' => $model->getKey(), 'from_type' => $model->getMorphClass()],
            ['external' => null, 'to_id' => $object->getKey(), 'to_type' => $object->getMorphClass()]
        );

        return $this;
    }

    /**
     * Link a model reosurce to an external url.
     *
     * @param Linker $model
     * @param string $external
     * @return Link
     */
    public function external(Linker $model, string $external)
    {
        $this->updateOrCreate(
            ['from_id' => $model->getKey(), 'from_type' => $model->getMorphClass()],
            ['external' => $external, 'to_id' => null, 'to_type' => null]
        );

        return $this;
    }
}
