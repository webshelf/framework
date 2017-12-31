<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 30/12/2017
 * Time: 18:47.
 */

namespace App\Classes\Library\PageLoader;

/*
 * Class NavItem
 *
 * @package App\Classes\Library\PageLoader
 */

use Illuminate\Support\Collection;

/**
 * Class NavItem.
 */
class NavItem
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $url = '#';

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var Collection
     */
    protected $children = [];

    /**
     * NavItem constructor.
     *
     * @param string $text
     * @param string $url
     * @param bool $active
     */
    public function __construct(string $text, string $url = '#', bool $active = false)
    {
        $this->text = $text;

        $this->url = $url;

        $this->active = $active;

        $this->children = new Collection;
    }

    public function addChild(self $navItem)
    {
        $this->children->put($navItem->text, $navItem);
    }

    /**
     * @return bool
     */
    public function classState()
    {
        return $this->active ? 'active' : 'inactive';
    }

    /**
     * @return string
     */
    public function url()
    {
        return url($this->url);
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->text;
    }

    /**
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
