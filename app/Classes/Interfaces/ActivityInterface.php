<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 24/09/2016
 * Time: 19:53.
 */

namespace App\Classes\Interfaces;

use App\Model\Account;

/**
 * Interface ActivityInterface.
 *
 * Implementation of this will cause laravel to track the creation, modification and deletion of models.
 */
interface ActivityInterface
{
    /**
     * Logs will store the model id to refer to at a later stage.
     *
     * @return int - ID of the model where the activity was held.
     */
    public function id();

    /**
     * Logs will display the activity title that was interacted with.
     *
     * @return  string  -  Title of the activity that should be shown on logs.
     */
    public function feed_title();

    /**
     * Logs will create an activity link to allow the user to browse activity upon click.
     *
     * @return  string  -  Url link that activity will be redirected to.
     */
    public function feed_url();

    /**
     * Get the creator model of the eloquent model.
     *
     * @return Account|mixed
     */
    public function creator();

    /**
     * Logs require a creator to determine who the original account is.
     *
     * @return int
     */
    public function creatorID();

    /**
     * Set the creator id to the creator column.
     *
     * @param int $integer
     * @return $this
     */
    public function setCreatorID(int $integer);

    /**
     * Get the creator model of the eloquent model.
     *
     * @return Account|mixed
     */
    public function editor();

    /**
     * Logs any changes to the model with the editor_column.
     *
     * @return int
     */
    public function editorID();

    /**
     * Set the editors id to the editor column.
     *
     * @param int $integer
     * @return $this
     */
    public function setEditorID(int $integer);
}
