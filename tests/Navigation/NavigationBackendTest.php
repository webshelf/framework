<?php

namespace Tests\Modules;

use Carbon\Carbon;
use App\Model\Menu;
use App\Model\Page;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class NavigationBackendTest.
 */
class NavigationBackendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_use_a_title_of_an_already_used_title_once_deleted(): void
    {
        $this->signIn();

        // create a menu that has been deleted.
        $menu = factory(Menu::class)->create(['title' => 'foo', 'deleted_at' => Carbon::now()->timestamp]);

        // create a new page for the new menu
        $new_page = factory(Page::class)->create();

        // encode to json for creation of a new link model
        $encoding = json_encode(['key' => $new_page->id, 'class' => $new_page->getMorphClass()]);

        // generate teh new menu with the encoding
        $new_menu = factory(Menu::class)->make(['title' => 'foo', 'linkable_object' => $encoding]);

        // get a request from the dashboard once passing the model to the url.
        $request = $this->post('/admin/navigation/', $new_menu->toArray());

        // make sure the database has the new menu added.
        $this->assertDatabaseHas('menus', ['title' => 'foo', 'page_id' => $new_menu->page->id]);
    }

    /**
     * @test
     */
    public function it_can_change_the_title_to_an_already_used_title_that_was_removed() : void
    {
        $this->signIn();

        // A menu that has been deleted.
        $menu = factory(Menu::class)->create(['title' => 'foo', 'deleted_at' => Carbon::now()->timestamp]);

        // the current menu to be changed
        /** @var Menu $current_menu */
        $current_menu = factory(Menu::class)->create(['title' => 'bar']);

        // set its title back to foo.
        $current_menu->setAttribute('title', 'foo');

        // send the new menu as a
        $request = $this->patch("/admin/navigation/{$current_menu->id}", $current_menu->toArray());

        // assert the database has the changed details.
        $this->assertDatabaseHas('menus', ['title' => 'foo', 'id' => $current_menu->getKey()]);
    }
}
