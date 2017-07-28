<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 23/03/2016
 * Time: 21:36.
 */

namespace App\Http\Controllers;

use App\Classes\Breadcrumbs;
use App\Classes\Repositories\MigrationRepository;

/**
 * Class UpdatesController.
 */
class UpdatesController extends DashboardController
{
    /**
     * @var MigrationRepository
     */
    private $migrations;

    /**
     * UpdatesController constructor.
     * @param Breadcrumbs $breadcrumbs
     * @param MigrationRepository $migrations
     */
    public function __construct(Breadcrumbs $breadcrumbs, MigrationRepository $migrations)
    {
        parent::__construct($breadcrumbs);

        $this->migrations = $migrations;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->view()->make('dashboard::modules.updates.view')->with('migrations', $this->migrations->all());
    }
}
