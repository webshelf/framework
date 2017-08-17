<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/03/2016
 * Time: 21:36.
 */

namespace App\Modules\Updates;

use App\Classes\Breadcrumbs;
use App\Classes\Repositories\MigrationRepository;
use App\Http\Controllers\DashboardController;
use App\Modules\ModuleEngine;

/**
 * Class Controller.
 */
class Controller extends ModuleEngine
{
    /**
     * @var MigrationRepository
     */
    private $migrations;

    /**
     * Controller constructor.
     * @param MigrationRepository $migrations
     */
    public function __construct(MigrationRepository $migrations)
    {
        $this->migrations = $migrations;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->make('view')->with('migrations', $this->migrations->all());
    }
}
