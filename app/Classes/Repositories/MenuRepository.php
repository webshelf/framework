<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 13/03/2016
 * Time: 19:52.
 */

namespace App\Classes\Repositories;

use App\Model\Menu;

/**
 * Class MenuRepository.
 *
 * @method Menu withTrashed
 */
class MenuRepository extends Menu
{
    /**
     * Return the Menu with the matching ID.
     *
     * @param int $integer
     * @return Menu
     */
    public function whereID(int $integer) : Menu
    {
        return $this->where('id', $integer)->first();
    }

    /**
     * Frontend requires that a organised list of menus is returned.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function organisedMenuList()
    {
        return $this->whereNull('parent_id')->where('status', true)->with('page')->orderBy('order', 'asc')->get();
    }

    /**
     * Top level menus, without any further parents.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function whereTopLevel()
    {
        return $this->whereNull('parent_id')->orderBy('order', 'asc')->get();
    }

    public function whereTopLevelEditable()
    {
        return $this->where('lock', null)->whereNull('parent_id')->orderBy('order', 'asc')->get();
    }

    /**
     * Where the menu belongs to a another menu.
     *
     * @param int $integer
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function whereParent(int $integer)
    {
        return ($integer == 1) ? $this->whereTopLevel() : $this->where('parent_id', $integer)->orderBy('order', 'asc')->get();
    }
}
