<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 06/12/2017
 * Time: 00:53.
 */

namespace App\Classes\Library\StyleCSS;

/**
 * Class Status.
 */
class Status extends Icons
{
    public function sitemap($boolean)
    {
        return $this->statusIcon('fa-sitemap', $boolean);
    }

    public function visibility($boolean)
    {
        return $this->statusIcon('fa-low-vision', $boolean);
    }

    public function status($boolean)
    {
        return $this->statusIcon('fa-cogs', $boolean);
    }

    public function check($boolean)
    {
        return $this->subjectiveIcon('fa-check', 'fa-times', $boolean);
    }

    public function installed($boolean)
    {
        return $this->statusIcon('fa-download', $boolean);
    }

    /**
     * Allows color based on boolean.
     */
    private function statusIcon(string $iconName, bool $boolean)
    {
        return $boolean ? $this->icon($iconName, 'green') : $this->icon($iconName, 'red');
    }

    /**
     * Allows separate icons based on boolean, with separate colors.
     */
    private function subjectiveIcon(string $iconTrue, string $iconFalse, bool $boolean)
    {
        if ($boolean)
            return $this->icon($iconTrue, 'green');
        else
            return $this->icon($iconFalse, 'red');
    }
}
