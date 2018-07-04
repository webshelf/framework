<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:22.
 */

namespace App\Classes\Library\PageLoader\Coordinators;

/**
 * Class Site.
 */
class Frame
{
    /**
     * @return mixed
     */
    public function name()
    {
        return config('app.name');
    }

    /**
     * @return mixed
     */
    public function copyright()
    {
        return 'Unknown';
    }
}
