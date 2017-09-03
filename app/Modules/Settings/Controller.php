<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 17:32.
 */

namespace App\Modules\Settings;

use App\Modules\ModuleEngine;
use Symfony\Component\HttpFoundation\Request;
use App\Classes\Repositories\SettingsRepository;

/**
 * Class Controller.
 */
class Controller extends ModuleEngine
{
    /**
     * @var SettingsRepository
     */
    private $settings;

    /**
     * Controller constructor.
     * @param SettingsRepository $settings
     */
    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Settings are already loaded within the application
     * best to use the loaded settings from that instead.
     *
     * Helper function (Settings())
     *
     * @return mixed
     */
    public function edit()
    {
        return $this->make('edit');
    }

    public function save(Request $request)
    {
        if ($request['setting.string']) {
            foreach ($request['setting.string'] as $key => $value) {
                ($this->settings->firstKey($key))->setValue($value ?: null)->save();
            }
        }

        if ($request['setting.boolean']) {
            foreach ($request['setting.boolean'] as $key => $value) {
                if ($value == 'on') {
                    $value = 1;
                }

                ($this->settings->firstKey($key))->setValue($value ?: null)->save();
            }
        }
        if ($request['setting.select']) {
            foreach ($request['setting.select'] as $key => $value) {
                ($this->settings->firstKey($key))->setValue($value ?: null)->save();
            }
        }

        return redirect()->intended(route('settings'));
    }
}
