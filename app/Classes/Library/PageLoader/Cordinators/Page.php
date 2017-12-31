<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:20
 */

namespace App\Classes\Library\PageLoader\Cordinators;

use App\Model\Page as Model;

class Page
{

    private $page;

    public function __construct(Model $page)
    {
        $this->page = $page;
    }

    public function name()
    {
        return $this->page->seo_title;
    }

    public function title();

    public function keywords();

    public function description();

    public function content();
}