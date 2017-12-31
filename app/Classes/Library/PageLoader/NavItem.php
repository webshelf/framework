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

use App\Model\Menu;
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
     * @var int
     */
    protected $order;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var Collection
     */
    public $children = [];

    /**
     * NavItem constructor.
     *
     * @param Menu $menu
     * @param bool $active
     */
    public function __construct(Menu $menu, bool $active = false)
    {
        $this->text = $menu->title;

        $this->url = $menu->link();

        $this->active = $active;

        $this->children = new Collection;
    }

    /**
     * @param NavItem $navItem
     */
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
}
