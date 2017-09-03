<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 24/12/2016
 * Time: 15:20.
 */

namespace App\Classes\Library\PageLoading;

use App\Model\Menu;
use App\Model\Page;
use App\Classes\Breadcrumbs;
use App\Classes\Repositories\MenuRepository;

/**
 * Class DataBuilder.
 */
class FrontPageBuilder
{
    protected $page;

    protected $current;

    /** @var FrontPageMenu */
    protected $menu;

    /**
     * FrontPageBuilder constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Search engine optimization creation
     * Includes the title, keywords and description that is used by search engines.
     *
     * @return array
     */
    public function transcribe()
    {
        if (settings()->getValue('seo_title_text_append') != '') {
            if (settings()->getValue('seo_title_text_position') == 'right') {
                $data['title'] = ucfirst($this->page->seo_title).' '.settings()->getValue('seo_title_text_seperator').' '.settings()->getValue('seo_title_text_append');
            } else {
                $data['title'] = settings()->getValue('seo_title_text_append').' '.settings()->getValue('seo_title_text_seperator').' '.ucfirst($this->page->seo_title);
            }
        } else {
            $data['title'] = ucfirst($this->page->seo_title);
        }

        $data['keywords'] = $this->page->seo_keywords ?: settings()->getValue('seo_keywords');

        $data['description'] = $this->page->seo_description ?: settings()->getValue('seo_description');

        return $data;
    }

    /**
     * Page content is the content created by the user for the page to use.
     * We may in future want to parse something so we have this on its
     * own method.
     *
     * @return mixed
     */
    public function content()
    {
        return $this->page->content;
    }

    /**
     * Each page can have a plugin feed of data that will be used along
     * with the page, here it is defined based on active plugins and
     * feed enabled plugins.
     *
     * @return array
     */
    public function plugins()
    {
        return [];
    }

    /**
     * Menus are user navigation that generate dynamically using database data.
     *
     * @return array
     */
    public function menus()
    {
        $menus = new FrontPageMenu((new MenuRepository)->allGlobalMenusWithSubmenus());

        $this->menu = $menus->make();

        return $this->menu->collection->toArray();
    }

    /**
     * The current submenu of the menu currently active.
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function sidebar()
    {
        return $this->menu->currentSubmenu ?? [];
    }

    /**
     * User navigation and finding a way back to the previous page.
     *
     * @return Breadcrumbs|array
     */
    public function breadcrumbs()
    {
        if (settings()->getValue('site_breadcrumbs') == true) {
            $breadcrumbs = new Breadcrumbs;

            $breadcrumbs->fromCurrentUrl();

            $breadcrumbs->homeExists(true);

            return $breadcrumbs;
        }

        return [];
    }

    /**
     * Details for users to contact the buissiness for future references.
     *
     * @return array
     */
    public function contact()
    {
        $data = [];
        $array = ['address_name', 'address_location', 'address_county', 'phone_number', 'fax_number', 'email_address'];

        foreach ($array as $information) {
            $data[$information] = settings()->getValue($information);
        }

        return $data;
    }

    /**
     * Footer copyright data to prevent people from copying or to state
     * buissiness.
     *
     * @return mixed
     */
    public function copyright()
    {
        return settings()->getValue('website_copyright');
    }
}
