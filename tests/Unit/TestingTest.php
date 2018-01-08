<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 07/01/2018
 * Time: 22:31
 */

namespace Tests\Unit;

use App\Model\Link;
use App\Model\Menu;
use App\Model\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestingTest extends TestCase
{

    public function testLinkableCreation()
    {
        /** @var Page $page */
        $page = Page::find(1);

        /** @var Menu $menu */
        $menu = Menu::find(1);

        $link = new Link;
        $link->internal = $page->slug();

        $page->links()->save($link);

        $menu->link = $link->id;

        dd($menu->link);
    }

}
