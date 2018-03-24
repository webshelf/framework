<?php

namespace App\Classes\Library\PageLoader\Coordinators;

/**
 * Class Contact.
 */
class Contact
{
    /**
     * @return mixed
     */
    public function address()
    {
        return settings()->getValue('address');
    }

    /**
     * @return mixed
     */
    public function phone()
    {
        return settings()->getValue('phone_number');
    }

    /**
     * @return mixed
     */
    public function fax()
    {
        return settings()->getValue('fax_number');
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return settings()->getValue('email_address');
    }
}
