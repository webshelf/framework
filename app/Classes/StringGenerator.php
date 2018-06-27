<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 27/06/2018
 * Time: 19:07
 */

namespace App\Classes;


class StringGenerator
{
    /**
     * Strip the name from an email domain.
     *
     * @param string $email The string to be parsed.
     * @return string The returned stripped string.
     */
    public static function stripEmail(string $email)
    {
        return strstr($email, '@', true);
    }
}