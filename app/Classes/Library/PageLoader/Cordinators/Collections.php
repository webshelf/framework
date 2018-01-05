<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 31/12/2017
 * Time: 02:23.
 */

namespace App\Classes\Library\PageLoader\Cordinators;

use App\Classes\Breadcrumbs;
use App\Model\Page as Model;
use App\Classes\Library\PageLoader\Navigation;

/**
 * Class Collections.
 */
class Collections
{
    /**
     * @var \App\Model\Page
     */
    private $model;

    /**
     * @var Navigation
     */
    private $navigation;

    /**
     * Collections constructor.
     *
     * @param Model $model
     * @param Navigation $navigation
     */
    public function __construct(Model $model, Navigation $navigation)
    {
        $this->model = $model;

        $this->navigation = $navigation;
    }

    /**
     * @return array
     */
    public function plugins()
    {
        return [];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->navigation->collection;
    }

    /**
     * @return array
     */
    public function sidebar()
    {
        if ($this->model->menu && $this->model->menu->parent) {
            $collection = $this->navigation->collection->get($this->model->menu->parent->title);

            return $collection->children;
        }

        if ($this->model->menu) {
            $collection = $this->navigation->collection->get($this->model->menu->title);

            return $collection->children;
        }

        return [];
    }

    /**
     * @return bool
     */
    public function hasSidebar()
    {
        return $this->model->menu || $this->model->menu && $this->model->menu->parent;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function breadcrumbs()
    {
        return Breadcrumbs::fromCurrentRoute()->crumbs();
    }
}
