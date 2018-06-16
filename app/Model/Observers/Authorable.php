<?php

namespace App\Database\Observers;

use Illuminate\Database\Eloquent\Model;

/**
 * Authorable Observing for the model tracking.
 */
class Authorable
{
    /**
     * Update the creator id when the model is being created.
     *
     * @param Model $model
     * @return bool
     */
    public function creating(Model $model)
    {
        return $model->setAttribute('creator_id', auth()->id());
    }

    /**
     * Update the editor id when the model is being edited.
     *
     * @param Model $model
     * @return void
     */
    public function updating(Model $model)
    {
        return $model->setAttribute('editor_id', auth()->id());
    }

    /**
     * Update the editor id when the model is being deleted.
     *
     * @param Model $model
     * @return void
     */
    public function deleting(Model $model)
    {
        return $model->setAttribute('editor_id', auth()->id());
    }
}
