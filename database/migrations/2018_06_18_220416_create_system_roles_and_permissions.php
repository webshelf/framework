<?php

use App\Model\Role;
use App\Model\Account;
use App\Classes\Roles\Developer;
use App\Classes\StringGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('login_count')->default(0);
        });

        Schema::create('system_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });

        Role::create([
            'name' => 'developer',
            'title' => 'Developer',
            'description' => 'System wide access to engine properties, debugging and tools.',
        ]);

        Role::create([
            'name' => 'administrator',
            'title' => 'Administrator',
            'description' => 'Administrators have super user access to the entire site.',
        ]);

        Role::create([
            'name' => 'publisher',
            'title' => 'Publisher',
            'description' => 'Publishers have the ability to manage all content on the platform without access to settings.',
        ]);

        Role::create([
            'name' => 'disabled',
            'title' => 'Disabled',
            'description' => 'A disabled account will have no access to the dashboard and lose all permissions.',
        ]);

        Schema::table('plugins', function (Blueprint $table) {
            $table->dropColumn('installed');
        });

        Schema::table('article_categories', function (Blueprint $table) {
            $table->unsignedInteger('creator_id')->default(1)->change();
            $table->unsignedInteger('editor_id')->default(1)->change();
        });

        (new Developer)->apply(Account::first());

        Schema::table('article_categories', function (Blueprint $table) {
            $table->string('slug')->after('id')->change();
        });

        // Update indexing for model searching. (Laravel Scout)
        Artisan::call('scout:mysql-index');

        Schema::table('accounts', function (Blueprint $table) {
            $table->string('username')->after('id')->default(str_slug(Faker\Factory::create()->userName));
        });

        foreach (Account::all() as $account) {
            $account->update(['username' => StringGenerator::stripEmail($account->email)]);
        }

        Artisan::call('scout:mysql-index');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
