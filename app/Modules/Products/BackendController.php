<?php

namespace App\Modules\Products;

use App\Modules\ModuleEngine;
use App\Modules\ModuleManager;

/**
 * Class BackendController.
 */
class BackendController extends ModuleEngine
{
    /**
     * BackendController constructor.
     */
    public function __construct()
    {
        $this->middleware(['role:developer']);
    }

    /**
     * Display a list of products available and disable, enable option for super admins.
     */
    public function index()
    {
        return $this->make('index');
    }

    /**
     * Toggle the enable or disable of a module.
     *
     * @param string $module
     * @param ModuleManager $modules
     */
    public function toggle(string $module, ModuleManager $modules)
    {
        //
    }
}
