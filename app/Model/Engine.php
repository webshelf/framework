<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 29/11/2016
 * Time: 14:58.
 */

namespace App\Model;

use App\Classes\ActivityTracker;
use App\Classes\Interfaces\ActivityInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Engine.
 */
abstract class Engine extends EloquentModel
{
    /**
     * The activities that will be saved to database.
     *
     * @var array
     */
    protected $activities = ['modify', 'create', 'delete'];

    /**
     * Should we track the changes on a eloquent model save.
     *
     * @var bool
     */
    protected $trackChanges = true;

    /**
     * Should we save the modification id to the eloquent table?
     * Requires editor_id column in the table to save to.
     *
     * @var bool
     */
    protected $trackModifier = true;

    /**
     * Check if activity should be saved.
     *
     * @return bool
     */
    private function hasModifier() : bool
    {
        return $this->trackModifier;
    }

    /**
     * @param string $key
     * @return bool
     */
    private function hasActivity(string $key) : bool
    {
        if ($this->trackChanges) {
            return in_array($key, $this->activities);
        }

        return false;
    }

    /**
     * Allow activity changes to save to database.
     *
     * @param array $options
     * @return bool
     * @throws \Exception
     */
    public function save(array $options = [])
    {
        if ($this->trackChanges) {
            $model = ['existed' => $this->exists, 'dirty' => $this->isDirty()];

            parent::save($options);

            if ($this instanceof ActivityInterface) {
                if ($model['existed']) {
                    if ($this->hasActivity('modify') && $model['dirty']) {
                        $this->setEditorID(account()->id());

                        ActivityTracker::track(Activity::$interactions['modified'], $this);
                    }
                } else {
                    if ($this->hasActivity('create')) {
                        $this->setCreatorID(account()->id());

                        $this->setEditorID(account()->id());

                        ActivityTracker::track(Activity::$interactions['created'], $this);
                    }
                }

                return parent::save();
            }
        }

        return parent::save($options);
    }

    /**
     * Delete method for removal of models.
     */
    public function delete()
    {
        if ($this->trackChanges && $this instanceof ActivityInterface && $this->hasActivity('delete')) {
            $this->setEditorID(account()->id());

            parent::save();

            ActivityTracker::track(Activity::$interactions['deleted'], $this);
        }

        return parent::delete();
    }

    /**
     * Set avoid to track following eloquent model.
     *
     * @return Engine
     */
    public function withoutTracking()
    {
        return $this->setTrackChanges(false);
    }

    /**
     * @param bool $boolean
     * @return $this
     */
    public function setTrackChanges(bool $boolean)
    {
        $this->trackChanges = $boolean;

        return $this;
    }
}
