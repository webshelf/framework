<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/03/2016
 * Time: 21:36.
 */

namespace App\Modules\Updates;

use App\Modules\ModuleEngine;
use App\Classes\Repositories\MigrationRepository;

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
