<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 08/01/2018
 * Time: 16:59.
 */

namespace App\Classes\Interfaces;

use App\Model\Link;

interface LinkableInterface
{
    /**
     * @return Link
     */
    public function link();
}
