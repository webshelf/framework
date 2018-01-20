<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 18/01/2018
 * Time: 14:31.
 */

namespace App\Classes\Interfaces;

/**
 * Interface Linkable.
 */
interface Linkable extends Linker
{
    /**
     * The url that is used to view this model.
     *
     * @return string
     */
    public function route();
}
