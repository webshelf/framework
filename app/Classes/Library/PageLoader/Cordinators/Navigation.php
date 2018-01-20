<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:23.
 */

namespace App\Classes\Library\PageLoader\Cordinators;

use App\Model\Menu;
use App\Model\Page;
use App\Classes\Breadcrumbs;
use Illuminate\Support\Collection;

/**
 * Class Collections.
 */
class Navigation
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
     * @var Menu
     */
    private $activeMenu;

    /**
     * Collections constructor.
     *
     * @param \App\Model\Page $page
     * @param Collection $navigation
     */
    public function __construct(Page $page, Collection $navigation)
    {
        $this->page = $page;

        $this->navigation = $navigation;

        $this->lookupCurrentMenu();
    }

    /**
     * @param Menu $menu
     * @return bool
     */
    private function isCurrent(Menu $menu)
    {
        return $this->page->route() == $menu->link->url();
    }

    /**
     * Activate, the current menu.
     */
    private function lookupCurrentMenu()
    {
        foreach ($this->navigation as $menu) {
            foreach ($menu->children as $submenu) {
                if ($this->isCurrent($submenu)) {
                    $this->setActiveMenu($submenu);

                    break;
                }
            }

            if ($this->hasActiveMenu()) {
                $menu->active = true;

                break;
            } elseif ($this->isCurrent($menu)) {
                $this->setActiveMenu($menu);

                break;
            }
        }
    }

    public function setActiveMenu(Menu $menu)
    {
        $this->activeMenu = $menu;

        return $menu->active = true;
    }

    /**
     * @return bool
     */
    private function hasActiveMenu()
    {
        return $this->activeMenu ? true : false;
    }

    /**
     * @return array
     */
    public function plugins()
    {
        return [];
    }

    /**
     * Main menu construction.
     */
    public function main()
    {
        return $this->navigation;
    }

    /**
     * @return Menu|array
     */
    public function sidebar()
    {
        if ($this->hasActiveMenu()) {
            if ($this->activeMenu->parent) {
                $menu = $this->navigation->where('title', $this->activeMenu->parent->title)->first();

                return $menu->children;
            }

            $menu = $this->navigation->where('title', $this->activeMenu->title)->first();

            return $menu->children;
        }

        return [];
    }

    /**
     * @return bool
     */
    public function hasSidebar()
    {
        return false;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function breadcrumbs()
    {
        return Breadcrumbs::fromCurrentRoute()->crumbs();
    }
}
