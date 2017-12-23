<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 06/12/2017
 * Time: 12:50.
 */

namespace App\Classes\Library\StyleCSS;

class Icons
{
    /**
     * Generate the icon format and color, apply the url link if exists.
     *
     * @param string $iconName
     * @param string $color
     * @param string $link
     * @return string
     */
    protected function icon(string $iconName, string $color = null, string $link = null)
    {
        if ($link) {
            return sprintf('<a href="%s">%s</a>', $link, $this->icon($iconName, $color));
        }

        return sprintf('<i class="fa %s %s" aria-hidden="true"></i>', $iconName, $color);
    }
}
