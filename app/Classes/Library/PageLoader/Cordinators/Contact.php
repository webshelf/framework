<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:19.
 */

namespace App\Classes\Library\PageLoader\Cordinators;

use App\Classes\SettingsManager;

/**
 * Class Contact.
 */
class Contact
{
    /**
     * @var SettingsManager
     */
    private $settings;

    /**
     * Contact constructor.
     *
     * @param SettingsManager $settings
     */
    public function __construct(SettingsManager $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return mixed
     */
    public function address()
    {
        return $this->settings->getValue('address');
    }

    /**
     * @return mixed
     */
    public function phone()
    {
        return $this->settings->getValue('phone_number');
    }

    /**
     * @return mixed
     */
    public function fax()
    {
        return $this->settings->getValue('fax_number');
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->settings->getValue('email_address');
    }
}
