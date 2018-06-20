<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Schema\Schema as Doctrine;
use Illuminate\Support\Facades\Schema;
use App\Model\Role;
use App\Model\Page;

class CreateSystemRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function(Blueprint $table) {
            $table->dropColumn('role_id');
        });
        
        Schema::table('accounts', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->after('verified');
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
            'description' => 'System wide access to engine properties, debugging and tools.'
        ]);

        Role::create([
            'name' => 'administrator', 
            'title' => 'Administrator',   
            'description' => 'Administrators have super user access to the entire site.'
        ]); 

        Role::create([
            'name' => 'publisher',       
            'title' => 'Publisher', 
            'description' => 'Publishers have the ability to manage all content on the platform without access to settings.'
        ]);

        Role::create([
            'name' => 'disabled',
            'title' => 'Disabled', 
            'description' => 'A disabled account will have no access to the dashboard and lose all permissions.'
        ]);
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
