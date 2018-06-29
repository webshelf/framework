<?php

namespace Tests\Unit;

use App\Classes\Roles\Administrator;
use App\Classes\Roles\Developer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
