<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 11/03/2016
 * Time: 17:32.
 */

namespace App\Http\Controllers;

use App\Classes\Breadcrumbs;
use Symfony\Component\HttpFoundation\Request;
use App\Classes\Repositories\SettingsRepository;

/**
 * Class SettingsController.
 */
class SettingsController extends DashboardController
{
    /**
     * @var SettingsRepository
     */
    private $settings;

    /**
     * SettingsController constructor.
     * @param Breadcrumbs $breadcrumbs
     * @param SettingsRepository $settings
     */
    public function __construct(Breadcrumbs $breadcrumbs, SettingsRepository $settings)
    {
        parent::__construct($breadcrumbs);

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
        return $this->view()->make('dashboard::modules.settings.edit');
    }

    public function save(Request $request)
    {
        if ($request['setting.string']) {
            foreach ($request['setting.string'] as $key => $value) {
                ($this->settings->whereKey($key))->setValue($value ?: null)->save();
            }
        }

        if ($request['setting.boolean']) {
            foreach ($request['setting.boolean'] as $key => $value) {
                if ($value == 'on') {
                    $value = 1;
                }

                ($this->settings->whereKey($key))->setValue($value ?: null)->save();
            }
        }
        if ($request['setting.select']) {
            foreach ($request['setting.select'] as $key => $value) {
                ($this->settings->whereKey($key))->setValue($value ?: null)->save();
            }
        }

        return redirect()->intended(route('settings'));
    }
}
