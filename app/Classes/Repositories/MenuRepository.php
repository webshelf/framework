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
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MenuRepository.
 */
class MenuRepository
{
    /**
     * The model for eloquent access.
     *
     * @var Builder
     */
    private $model;

    /**
     * AccountRepository constructor.
     *
     * @param Menu $model
     */
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }

    public function whereID(int $integer) : Menu
    {
        return $this->model->where('id', $integer)->first();
    }

    public function restoreTrashedPlugin($plugin_name)
    {
        return $this->model->withTrashed()->where('slug', $plugin_name)->restore();
    }

    public function allByPriorityOrder()
    {
        return $this->model->whereNull('menu_id')->orderBy('order_id', 'asc')->get();
    }

    public function allByRowOrder()
    {
        return $this->model->whereNull('menu_id')->orderBy('order_id', 'asc')->get();
    }

    public function listAllMenusNotRequired()
    {
        return $this->model->whereNull('required')->pluck('title', 'id');
    }

    public function makeList()
    {
        return $this->model->pluck('title', 'id');
    }

    public function listWhereInternal()
    {
        return $this->model->whereNotNull('page_id')->whereNull('menu_id')->pluck('title', 'id');
    }

    public function submenusWhereID($integer)
    {
        return $this->model->where('menu_id', $integer)->get();
    }

    public function allMenus()
    {
        return $this->model->whereNull('menu_id')->get();
    }

    public function allMenusWhereID($integer)
    {
        return $this->model->where('menu_id', $integer)->get();
    }

    public function allSubmenus()
    {
        return $this->model->whereNotNull('menu_id')->get();
    }

    public function allSubmenusByPriorityOrderAndGrouped()
    {
        return$this->model->whereNotNull('menu_id')->orderBy('order_id', 'asc')->get()->groupBy('menu_id');
    }

    /**
     * @param $string
     * @return Menu|array|\stdClass
     */
    public function whereName($string)
    {
        return $this->model->where('slug', $string)->first();
    }

    /**
     * This will return the menus in order, that will be displayed in the front end.
     */
    public function whereFrontEndMenu() : Collection
    {
        return $this->model->whereNull('menu_id')->where('enabled', true)->orderBy('order_id', 'asc')->with('submenus')->get();
    }

    /**
     * Return a menus set of submenus from the database.
     */
    public function allSubmenusOfMenuID(int $integer) : Collection
    {
        return $this->model->where('menu_id', $integer)->where('enabled', true)->orderBy('order_id', 'asc')->get();
    }

    /**
     * Return all the global menus with the submenus and pages.
     */
    public function allGlobalMenusWithSubmenus()
    {
        return $this->model->whereNull('menu_id')->where('enabled', true)->with('page')->orderBy('order_id', 'asc')->get();
    }
}
