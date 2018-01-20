<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 18/01/2018
 * Time: 14:31.
 */

namespace App\Classes\Interfaces;

/**
 * Interface Linker.
 */
interface Linker
{
    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass();

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable();

    /**
     * The name of the current model object.
     *
     * @return string
     */
    public function name();
}
