<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 28/07/2017
 * Time: 22:00
 */

namespace App\Modules\Filemanager;

use App\Http\Controllers\DashboardController;
use App\Modules\ModuleEngine;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 */
class Controller extends ModuleEngine
{

    /**
     * Load the popup filemanager
     */
    public function load()
    {
        return $this->make('view');
    }
}