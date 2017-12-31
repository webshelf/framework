<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 00:15.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Page;
use Illuminate\Support\Collection;

/**
 * Class Webpage.
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
     * @return string
     */
    public function title()
    {
        if (settings()->getValue('seo_text') != '') {
            if (settings()->getValue('seo_position') == 'right') {
                return ucfirst($this->page->seo_title).' '.settings()->getValue('seo_separator').' '.settings()->getValue('seo_separator');
            } else {
               return settings()->getValue('seo_text').' '.settings()->getValue('seo_separator').' '.ucfirst($this->page->seo_title);
            }
        } else {
            return ucfirst($this->page->seo_title);
        }
    }

    /**
     * @return mixed
     */
    public function keywords()
    {
        return $this->page->seo_keywords ?: settings()->getValue('page_keywords');
    }

    /**
     * @return mixed
     */
    public function description()
    {
        return $this->page->seo_description ?: settings()->getValue('page_description');
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->page->content;
    }

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
    public function phone_number()
    {
        return settings()->getValue('phone_number');
    }

    /**
     * @return mixed
     */
    public function fax_number()
    {
        return settings()->getValue('fax_number');
    }

    /**
     * @return mixed
     */
    public function email_address()
    {
        return settings()->getValue('email_address');
    }

    /**
     * @return mixed
     */
    public function copyright()
    {
        return settings()->getValue('website_copyright');
    }

    /**
     * @return array
     */
    public function plugins()
    {
        // TODO: Implement plugins() method.

        return [];
    }

    /**
     * @return Collection
     */
    public function navigationItems()
    {
        return $this->navigation->collection;
    }

    /**
     * @return array
     */
    public function sidebarItems()
    {
        if ($this->page->menu->parent)
        {
            $collection = $this->navigation->collection->get($this->page->menu->parent->title);

            return $collection->children;
        }

        if ($this->page->menu)
        {
            $collection = $this->navigation->collection->get($this->page->menu->title);

            return $collection->children;
        }

        return [];
    }

    /**
     * @return array
     */
    public function breadcrumbItems()
    {
        // TODO: Implement breadcrumbItems() method.

        return [];
    }

}
