<?php

use App\Model\Role;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->softDeletes();
            $table->timestamps();
        });

        $role = new Role;
        $role->setTitle('Super User');
        $role->setDescription('System-wide access to engine properties.');
        $role->save();

        $role = new Role;
        $role->setTitle('Administrator');
        $role->setDescription('This is the top level user with full application control.');
        $role->save();

        $role = new Role;
        $role->setTitle('Content Creator');
        $role->setDescription('This user can manage content, but not settings.');
        $role->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('roles');
    }
}
