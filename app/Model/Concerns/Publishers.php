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
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->fill([
                   'creator_id' => auth()->id(),
                   'editor_id'  => auth()->id(),
                ]);
            }
        });

        static::deleting(function ($model) {
            if(auth()->check()) {
                return $model->setAttribute('editor_id', auth()->id());
            }
        });

        static::updating(function ($model) {
            if(auth()->check()) {
                return $model->setAttribute('editor_id', auth()->id());
            }
        });
    }
}
