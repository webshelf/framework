<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 13/03/2016
 * Time: 19:52.
 */

namespace App\Classes\Repositories;

use App\Model\Menu;
use Illuminate\Support\Collection;

/**
 * Class MenuRepository.
 *
 * @method Menu withTrashed
 */
class MenuRepository extends Menu
{
    public function whereID(int $integer) : Menu
    {
        return $this->where('id', $integer)->first();
    }

    public function restoreTrashedPlugin($plugin_name)
    {
        return $this->withTrashed()->where('slug', $plugin_name)->restore();
    }

    public function allByPriorityOrder()
    {
        return $this->whereNull('menu_id')->orderBy('order_id', 'asc')->get();
    }

    public function allByRowOrder()
    {
        return $this->whereNull('menu_id')->orderBy('order_id', 'asc')->get();
    }

    public function listAllMenusNotRequired()
    {
        return $this->whereNull('required')->pluck('title', 'id');
    }

    public function makeList()
    {
        return $this->pluck('title', 'id');
    }

    public function listWhereInternal()
    {
        return $this->whereNotNull('page_id')->whereNull('menu_id')->pluck('title', 'id');
    }

    public function submenusWhereID($integer)
    {
        return $this->where('menu_id', $integer)->get();
    }

    public function allMenus()
    {
        return $this->whereNull('menu_id')->get();
    }

    public function allMenusWhereID($integer)
    {
        return $this->where('menu_id', $integer)->get();
    }

    public function allSubmenus()
    {
        return $this->whereNotNull('menu_id')->get();
    }

    public function allSubmenusByPriorityOrderAndGrouped()
    {
        return$this->whereNotNull('menu_id')->orderBy('order_id', 'asc')->get()->groupBy('menu_id');
    }

    /**
     * @param $string
     * @return Menu|array|\stdClass
     */
    public function whereName($string)
    {
        return $this->where('slug', $string)->first();
    }

    /**
     * This will return the menus in order, that will be displayed in the front end.
     */
    public function whereFrontEndMenu() : Collection
    {
        return $this->whereNull('menu_id')->where('enabled', true)->orderBy('order_id', 'asc')->with('submenus')->get();
    }

    /**
     * Return a menus set of submenus from the database.
     */
    public function allSubmenusOfMenuID(int $integer) : Collection
    {
        return $this->where('menu_id', $integer)->where('enabled', true)->orderBy('order_id', 'asc')->get();
    }

    /**
     * Return all the global menus with the submenus and pages.
     */
    public function allGlobalMenusWithSubmenus()
    {
        return $this->whereNull('menu_id')->where('enabled', true)->with('page')->orderBy('order_id', 'asc')->get();
    }
}
