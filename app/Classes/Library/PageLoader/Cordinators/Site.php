<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:22
 */

namespace App\Classes\Library\PageLoader\Cordinators;


use App\Classes\SettingsManager;

/**
 * Class Site
 *
 * @package App\Classes\Library\PageLoader\Cordinators
 */
class Site
{

    /**
     * @var SettingsManager
     */
    private $settings;

    /**
     * Site constructor.
     *
     * @param SettingsManager $settingsManager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settings = $settingsManager;
    }

    /**
     * @return mixed
     */
    public function name() {
        return $this->settings->getValue('website_name');
    }

    /**
     * @return mixed
     */
    public function copyright()
    {
        return $this->settings->getValue('website_copyright');
    }
}