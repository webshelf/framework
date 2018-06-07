<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Permission;
use App\Model\Role;

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
            $table->string('description')->default('No description available.');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->string('description')->default('No description available.');
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

        // create permissions
        Permission::create(['name' => 'view', 'description' => 'Permission to view content on the platform.']);
        Permission::create(['name' => 'update', 'description' => 'Permission to edit or update content on the platform.']);
        Permission::create(['name' => 'delete', 'description' => 'Permission to delete content on the platform.']);
        Permission::create(['name' => 'create', 'description' => 'Permission to create new content on the platform.']);
        Permission::create(['name' => 'configure', 'description' => 'Permission to configure the settings on the platform']);
        Permission::create(['name' => 'debug', 'description' => 'Permission to use the platform debug tools and properties available.']);

        // create roles and assign created permissions

        // Role for developer
        $developer = Role::create(['name' => 'developer', 'description' => 'System wide access to engine properties and tools.']);
        // Permission for developer.
        $developer->givePermissionTo(Permission::all());

        // Role for administrator
        $administrator = Role::create(['name' => 'administrator', 'description' => 'Full permissions to the platform and the content.']);
        // Permission for administartor
        $administrator->givePermissionTo(Permission::all());
        $administrator->revokePermissionTo('debug');

        // Role for author
        $author = Role::create(['name' => 'author', 'description' => 'Permission to create, edit and delete on the platform without settings access.']);
        // Permission for author
        $author->givePermissionTo(Permission::all());
        $author->revokePermissionTo('configure');
        $author->revokePermissionTo('debug');

        // Role for editor
        $editor = Role::create(['name' => 'editor', 'description' => 'Permission to only edit existing content on the platform without settings access.']);
        // Permission for editor/
        $editor->revokePermissionTo('configure');
        $editor->revokePermissionTo('create');
        $editor->revokePermissionTo('delete');
        $editor->revokePermissionTo('debug');

        // Role for members.
        $member = Role::create(['name' => 'member', 'description' => 'A user who has joined your website by registering, they have no permissions to the platform']);
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
