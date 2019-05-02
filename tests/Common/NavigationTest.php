<?php

namespace Tests;

use App\Model\Menu;

/**
 * Class NavigationTest
 *
 * @package Tests
 */
class NavigationTest extends TestCase
{
    /**
     * @test
     */
    public function a_navigation_has_a_submenu()
    {
        $parent = factory(Menu::class)->create();

        $submenu = factory(Menu::class)->create(['title' => 'submenu', 'parent_id' => $parent]);

        $this->assertCount(1, $parent->children);
    }

    /**
     * @test
     */
    public function a_navigations_submenus_are_ordered()
    {
        $parent = factory(Menu::class)->create();
        $submenu1 = factory(Menu::class)->create(['order' => 2, 'title' => 'submenu1', 'parent_id' => $parent]);
        $submenu2 = factory(Menu::class)->create(['order' => 1, 'title' => 'submenu2', 'parent_id' => $parent]);

        // Menus should be returned based on its order from the relationship query.
        foreach ($parent->children as $index => $submenu)
        {
            $this->assertEquals($index+1, $submenu->order);
        }
    }
}