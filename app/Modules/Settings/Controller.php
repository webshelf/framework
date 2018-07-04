<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 17:32.
 */

namespace App\Modules\Settings;

use App\Model\Configuration;
use App\Modules\ModuleEngine;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Controller.
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
     * Save the changes for settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        if ($request['setting']['string']) {
            foreach ($request['setting']['string'] as $key => $value) {
                Configuration::set($key, $value);
            }
        }

        if ($request['setting']['boolean']) {
            foreach ($request['setting']['boolean'] as $key => $value) {
                Configuration::set($key, $value);
            }
        }
        if ($request['setting']['select']) {
            foreach ($request['setting']['select'] as $key => $value) {
                Configuration::set($key, $value);
            }
        }

        return redirect()->intended(route('admin.settings.index'));
    }
}
