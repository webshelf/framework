<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 06/12/2017
 * Time: 00:53
 */

namespace App\Classes\Library\StyleCSS;

/**
 * Class Style
 *
 * @package App\Classes\Library\StyleCSS
 */
class Style
{

    /**
     * @var Status
     */
    public $status;

    /**
     * @var Link
     */
    public $link;

    /**
     * Style constructor.
     *
     * @param Status $status
     * @param Link $link
     */
    public function __construct(Status $status, Link $link)
    {
        $this->status = $status;

        $this->link = $link;
    }
}