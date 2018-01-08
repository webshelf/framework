<?php

namespace App\Model;

use App\Classes\Interfaces\SluggableInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Link
 *
 * @property string $slug
 *
 * @property integer $from_id
 * @property string $from_type
 * @property integer $to_id
 * @property string $to_type
 *
 * @property Model $to
 * @property Model $from
 *
 * @package App\Model
 */
class Link extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function to()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function from()
    {
        return $this->morphTo();
    }

    public static function associate(Model $from, SluggableInterface $to)
    {
        $link = new Link([
            'slug' => $to->slug(),
            'to_id' => $to->id,
            'to_type' => $to->getMorphClass(),
            'from_id' => $from->id,
            'from_type' => $from->getMorphClass(),
        ]);

        return $link->save();
    }
}

