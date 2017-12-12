<?php

use App\Model\Menu;
use App\Model\Page;
use App\Model\Role;
use App\Model\Account;
use Illuminate\Database\Seeder;

class FrameworkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedHomepagePage();

        $this->seedSuperAccount();

        $this->seedHomepageMenu();
    }

    /**
     * Seed the homepage.
     */
    private function seedHomepagePage()
    {
        $page = new Page();
        $page->slug = 'index';
        $page->seo_title = 'Homepage';
        $page->sitemap = true;
        $page->enabled = true;
        $page->editable = false;
        $page->save();
    }

    private function seedSuperAccount()
    {
        $account = new Account;
        $account->email = 'marky360@live.ie';
        $account->password = '$2y$10$9i7d3opPydLSDSGLc86yieSB.ksofo4KOcO6DdpONFFMHcEIPPRUy';
        $account->forename = 'Mark';
        $account->surname = 'Hester';
        $account->verified = true;
        $account->role_id = Role::SUPERUSER;
        $account->save();
    }

    private function seedHomepageMenu()
    {
        $menu = new Menu;
        $menu->title = ('Homepage');
        $menu->target = ('_self');
        $menu->order = 1;
        $menu->page_id = 1;
        $menu->status = true;
        $menu->lock = true;
        $menu->creator_id = 1;
        $menu->save();
    }
}
