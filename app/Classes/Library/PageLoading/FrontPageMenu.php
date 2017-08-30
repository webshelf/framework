<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 24/12/2016
 * Time: 00:11.
 */

namespace App\Classes\Library\PageLoading;

use App\Model\Menu;
use App\Model\Page;
use Illuminate\Support\Collection;

class FrontPageMenu
{
    /**
     * @var Collection
     */
    private $menus;

    /**
     * @var Collection
     */
    public $collection;

    /**
     * @var Collection
     */
    public $currentSubmenu;

    /**
     * FrontPageMenu constructor.
     *
     * @param Collection $menus
     */
    public function __construct(Collection $menus)
    {
        $this->menus = $menus;

        $this->collection = new Collection;
    }

    /**
     * Check if the current page is the current menu.
     *
     * @param Menu $menu
     * @return bool
     */
    public function isCurrentPageMenu(Menu $menu)
    {
        return ($menu->page->slug == currentURI()) ? true : false;
    }

    /**
     * Array for return data to be used by front end.
     *
     * @param Menu $menu
     * @param bool $boolean
     * @return array
     */
    public function collect(Menu $menu, $status = false)
    {
        return [
            'title'    => $menu->title(),
            'link'     => makeSlug($menu->page),
            'icon'     => $menu->icon(),
            'order'    => $menu->orderId(),
            'target'   => $menu->target(),
            'active'   => $status ? 'active' : 'inactive',
            'submenu'  => [],
        ];
    }

    public function make()
    {
        /** @var Menu $menu */
        foreach ($this->menus as $menu) {
            $submenus = new Collection();

            $menu_status = false;

            /** @var Menu $submenu */
            foreach ($menu->submenus as $submenu) {
                $status = $this->isCurrentPageMenu($submenu);

                if ($status == true) {
                    $menu_status = true;
                }

                $submenus->put($submenu->title(), $this->collect($submenu, $status));
            }

            if (! $menu_status) {
                $menu_status = $this->isCurrentPageMenu($menu);
            }

            if ($menu_status == true) {
                $this->currentSubmenu = $submenus->sortBy('order')->toArray();
            }

            $this->collection->put($menu->title(), array_merge($this->collect($menu, $menu_status), ['submenu' => $submenus->sortBy('order')->toArray()] ?? []));
        }

        return $this;
    }
}
