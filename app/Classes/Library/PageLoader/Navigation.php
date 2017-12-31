<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 30/12/2017
 * Time: 18:51.
 */

namespace App\Classes\Library\PageLoader;

use App\Model\Menu;
use Illuminate\Support\Collection;

/**
 * Class Navigation.
 */
class Navigation
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var Collection
     */
    public $collection = [];

    /**
     * Navigation constructor.
     *
     * @param Collection $repository
     */
    public function __construct(Collection $repository)
    {
        $this->routes = $this->splitRoutes();

        $this->collection = $this->generateNav($repository->keyBy('title'));
    }

    /**
     * @param Collection $repository
     * @return Collection
     */
    protected function generateNav(Collection $repository)
    {
        $collection = new Collection;

        /** @var Menu $item */
        foreach ($repository as $item) {
            $collection->put($item->title, $parent = $this->makeNavItem($item));

            /* @var NavItem $parent */
            foreach ($item->children as $new) {
                $parent->addChild($this->makeNavItem($new));
            }
        }

        return $this->collection = $collection;
    }

    /**
     * @return array
     */
    private function splitRoutes()
    {
        $path = app('request')->path();

        if ($path == '/') {
            return $this->routes = ['index'];
        }

        return explode('/', $path);
    }

    /**
     * @default $menu->page->slug == currentURI() ? true : false;
     * @param string $string
     * @return bool
     */
    public function isActiveTitle(string $string)
    {
        return in_array(str_slug($string), $this->routes);
    }

    /**
     * @param $menu
     * @return NavItem
     */
    protected function makeNavItem(Menu $menu): NavItem
    {
        return new NavItem($menu, $this->isActiveTitle($menu->page->slug));
    }
}
