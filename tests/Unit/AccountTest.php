<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\Roles\Developer;
use App\Classes\Roles\Administrator;

class AccountTest extends TestCase
{
    /**
     * @test
     */
    public function a_developer_obtains_role_of_administrator()
    {
        $developer = factory('App\Model\Account')->make();

        $developer->setRole(new Developer);

        $this->assertTrue($developer->hasRole(new Administrator));
    }
}
