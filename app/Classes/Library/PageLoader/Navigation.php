<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 30/12/2017
 * Time: 18:51
 */

namespace App\Classes\Library\PageLoader;


use App\Model\Menu;
use Illuminate\Support\Collection;

class Navigation
{
    /**
     * @var array
     */
    private $paths = [];

    /**
     * @var Collection
     */
    private $collection = [];

    /**
     * Navigation constructor.
     *
     * @param Collection $repository
     */
    public function __construct(Collection $repository)
    {
        $this->paths = $this->currentPathToArray();

        $this->collection = $this->generate($repository->keyBy('title'));
    }

    /**
     * @param Collection $repositoryCollection
     * @return Collection
     */
    protected function generate(Collection $repositoryCollection)
    {
        $collection = new Collection;

        /** @var Menu $item */
        foreach ($repositoryCollection as $item)
        {
            $collection->put($item->title, $parent = $this->makeNavItem($item));

             /** @var NavItem $parent */
            foreach ($item->children as $new)
            {
                $parent->addChild($this->makeNavItem($new));
            }
        }

        return $this->collection = $collection;
    }

    /**
     * @return string
     */
    private function currentPath()
    {
        return app('request')->path();
    }

    /**
     * @return array
     */
    private function currentPathToArray()
    {
        if ($this->currentPath() == '/')
        {
            return $this->paths = ['index'];
        }

        return explode('/', $this->currentPath());
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isCurrentNavigation(string $string)
    {
        return in_array(str_slug($string), $this->paths);
    }

    /**
     * @param $menu
     * @return NavItem
     */
    protected function makeNavItem(Menu $menu): NavItem
    {
        return new NavItem($menu->title, $menu->link(), $this->isCurrentNavigation($menu->page->slug));
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }
}