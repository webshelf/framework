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
        return config('website.contact.address');
    }

    /**
     * @return mixed
     */
    public function phone()
    {
        return config('website.contact.phone');
    }

    /**
     * @return mixed
     */
    public function fax()
    {
        return config('website.contact.fax');
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return config('website.contact.email');
    }
}
