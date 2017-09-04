<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/03/2016
 * Time: 21:36.
 */

namespace App\Modules\Updates;

use App\Modules\ModuleEngine;
use App\Classes\Repositories\UpdateRepository;

/**
 * Class Controller.
 */
class Controller extends ModuleEngine
{
    /**
     * @var UpdateRepository
     */
    private $migrations;

    /**
     * Controller constructor.
     * @param UpdateRepository $migrations
     */
    public function __construct(UpdateRepository $migrations)
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
