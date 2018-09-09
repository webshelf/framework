<?php

namespace App\Modules\Metrics\Models;

/**
 * Trait Clicks
 *
 * @property integer $clicks
 *
 * @package App\Modules\Metrics\Models
 */
class Clicks extends \Illuminate\Database\Eloquent\Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'metric_clicks';

    /**
     * Get all the viewable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function clickable()
    {
        return $this->morphTo();
    }
}