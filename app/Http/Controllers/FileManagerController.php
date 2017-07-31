<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 28/07/2017
 * Time: 22:00
 */

namespace App\Http\Controllers;

/**
 * Class FileManagerController
 *
 * @package App\Http\Controllers
 */
class FileManagerController extends DashboardController
{

    /**
     * Load the popup filemanager
     */
    public function load()
    {
        return $this->view()->make('dashboard::modules.filemanager.view');
    }
}