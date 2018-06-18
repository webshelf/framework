<?php

namespace App\Model\Concerns;

/**
 * Undocumented trait.
 */
trait Publishers
{
    /**
     * Author tracking.
     *
     * @return void
     */
    public static function bootPublishers()
    {
        if (! app()->runningInConsole()) {
            static::creating(function ($model) {
                $model->setAttribute('creator_id', auth()->id());
                $model->setAttribute('editor_id', auth()->id());
            });

            static::deleting(function ($model) {
                return $model->setAttribute('editor_id', auth()->id());
            });

            static::updating(function ($model) {
                return $model->setAttribute('editor_id', auth()->id());
            });
        }
    }
}
