<?php

use App\Model\Page;
use App\Model\Menu;
use App\Model\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Account::class, 35)->create();

        factory(Page::class, 75)->create();

        factory(Menu::class, rand(4,7))->states('parent')->create();

        factory(Menu::class, 32)->create();

        $account = new Account;
        $account->forename = 'Super';
        $account->surname = 'User';
        $account->verified = true;
        $account->role_id = 1;
        $account->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; //secret
        $account->email = 'webshelf@test.net';
        $account->save();
    }
}
