<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:15
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use Illuminate\Support\Collection;

/**
 * Class Webpage
 *
 * @package App\Classes\Library\PageLoader
 */
class Webpage
{
    /**
     * @var Page
     */
    private $page;

    /**
     * @var Navigation
     */
    private $navigation;

    /**
     * @param Page $page
     * @param Collection $navigationRepository
     */
    public function __construct(Page $page, Collection $navigationRepository)
    {
        $this->page = $page;

        $this->navigation = new Navigation($navigationRepository);
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->page->seo_title;
    }

    /**
     * @return array
     */
    public function navigationItems()
    {
        return $this->navigation->getCollection()->toArray();
    }

    public function sidebarItems()
    {
        return [];
    }
}