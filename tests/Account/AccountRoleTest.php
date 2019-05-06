<?php

namespace Tests\Account;

use Tests\TestCase;
use App\Classes\Roles\Developer;
use App\Classes\Roles\Administrator;

class AccountRoleTest extends TestCase
{
    /**
     * @test
     */
    public function a_developer_obtains_role_of_administrator()
    {
        $account = factory('App\Model\Account')->make();

        $account->setRole(new Developer);

        $this->assertTrue($account->hasRole(new Administrator));
    }
}
