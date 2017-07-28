<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 29/11/2016
 * Time: 15:45.
 */

namespace App\Classes;

use App\Model\Activity;
use App\Classes\Interfaces\ActivityInterface;

/**
 * Class ActivityTracker.
 */
class ActivityTracker
{
    /**
     * Integer is the activity interaction id, which can be called using Activity::$interaction['action'];.
     *
     * @param  int $interaction
     * @param  ActivityInterface $model
     */
    public static function track(int $interaction, ActivityInterface $model)
    {
        $activity = new Activity();

        $activity->setInteractionID($interaction);

        $activity->setActivityID($model->id());

        $activity->setActivityType(strtolower(class_basename($model)));

        $activity->setAccount($model->editorID()); // this should be set to the publisher id integer. !!!

        $activity->save();
    }
}
