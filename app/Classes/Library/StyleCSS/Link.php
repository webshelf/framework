<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 06/12/2017
 * Time: 00:57.
 */

namespace App\Classes\Library\StyleCSS;

/**
 * Class Link.
 */
class Link extends Icons
{
    public function edit(string $url)
    {
        return $this->icon('fa-pencil', 'blue', $url);
    }

    public function view(string $url)
    {
        return $this->icon('fa-globe', 'blue', $url);
    }
}
