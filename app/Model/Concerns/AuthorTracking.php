<?php

namespace App\Database\Concerns;

use App\Database\Observers\Authorable;

/**
 * Undocumented trait.
 */
trait AuthorTracking
{
    /**
     * Author tracking.
     *
     * @return void
     */
    public static function bootAuthorable()
    {
        static::creating(function($model) {
            return $model->setAttribute('creator_id', auth()->id());
        });

        static::deleting(function($model) {
            return $model->setAttribute('editor_id', auth()->id());
        });

        static::updating(function($model) {
            return $model->setAttribute('editor_id', auth()->id());
        });
    }
}
