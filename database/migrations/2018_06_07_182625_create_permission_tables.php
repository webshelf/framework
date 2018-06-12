<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Permission;
use App\Model\Role;
use App\Model\Account;
use Illuminate\Support\Facades\Artisan;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // drop old tables.
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');

        // create new tables.
        $tableNames = config('permission.table_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('guard_name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->morphs('model');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('role_id');
            $table->morphs('model');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);

            app('cache')->forget('spatie.permission.cache');
        });


        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        /*
        |--------------------------------------------------------------------------
        | Create the permissions for the platform.
        |--------------------------------------------------------------------------
        */
        Permission::create(['name' => 'debug',     'title' => 'Debug', 'description' => 'Permission to use the platform debug tools and properties available.']);
        Permission::create(['name' => 'configure', 'title' => 'Configure', 'description' => 'Permission to configure the settings on the platform']);

        /*
        |--------------------------------------------------------------------------
        | Create the roles for the platform
        |--------------------------------------------------------------------------
        */
        
        $developer     = Role::create(['name' => 'developer',     'title' => 'Developer',       'description' => 'System wide access to engine properties, debugging and tools.']);
        $administrator = Role::create(['name' => 'administrator', 'title' => 'Administrator',   'description' => 'Administrators have super user access to the entire site.']);
        $manager       = Role::create(['name' => 'manager',       'title' => 'Content Manager', 'description' => 'Content Managers have the ability to manage all content on the platform without access to settings.']);
        $user          = Role::create(['name' => 'user',          'title' => 'Registered User', 'description' => 'Registered Users are those who have completed your site’s user registration form to gain access to your website material.']);
        
        /*
        |--------------------------------------------------------------------------
        | Assign the permissions to the roles.
        |--------------------------------------------------------------------------
        */
        $developer->givePermissionTo(Permission::all());
        $administrator->givePermissionTo(Permission::all());
        $manager->givePermissionTo(Permission::all());

        // remove the permissions not viable
        $administrator->revokePermissionTo('debug');
        $manager->revokePermissionTo('debug');
        $manager->revokePermissionTo('configure');

        foreach (Account::all() as $account)
        {
            if ($account->id == 1) {
                $account->assignRole('developer');
            } else {
                $account->assignRole('administrator');
            }
        }

        // recache due to changed in config file.
        Artisan::call('config:cache');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
