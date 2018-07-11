<?php

namespace App\Modules\Configs;

use App\Model\Configuration;
use App\Modules\ModuleEngine;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Controller
 *
 * @package App\Modules\Configs
 */
class Controller extends ModuleEngine
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->middleware(['role:administrator']);
    }

    /**
     * Settings are already loaded within the application
     * best to use the loaded settings from that instead.
     *
     * Helper function (Settings())
     *
     * @return mixed
     */
    public function index()
    {
        return $this->make('index');
    }

    /**
     * Save the changes for system_config.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        foreach ($request['setting'] as $key => $value) {
            Configuration::set($key, $value);
        }

        return redirect()->intended(route('admin.settings.index'));
    }
}
