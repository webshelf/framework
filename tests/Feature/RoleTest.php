<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Role;
use App\Model\Account;
use App\Classes\Roles\Disabled;
use App\Classes\Roles\Administrator;
use App\Classes\Roles\Developer;
use App\Classes\Roles\Publisher;

/**
 * Undocumented class
 */
class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_new_account_will_default_to_the_administrator_role()
    {
        $account = factory('App\Model\Account')->create();

        $this->assertTrue($account->hasRole(new Administrator));
    }

    /**
     * @test
     */
    public function a_developer_obtains_role_of_administrator()
    {
        $developer = factory('App\Model\Account')->create();

        $developer->setRole(new Developer);

        $this->assertTrue($developer->hasRole(new Administrator));
    }

    /**
    * @test
    */
    public function a_disabled_account_cannot_access_dashboard()
    {
        $this->signIn(['role_id' => Disabled::$key]);

        $this->get('/admin')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['error' => 'Access to dashboard disabled']);
    }

    /**
     * @test
     */
    public function all_roles_can_access_dashboard_except_disabled()
    {
        $this->signIn();

        account()->setRole(new Developer);
        $this->get('/admin')->assertSee(account()->fullName());

        account()->setRole(new Administrator);
        $this->get('/admin')->assertSee(account()->fullName());

        account()->setRole(new Publisher);
        $this->get('/admin')->assertSee(account()->fullName());

        account()->setRole(new Disabled);
        $this->get('/admin')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'error' => 'Access to dashboard disabled'
            ]);
    }

    /**
     * @test
     */
    public function roles_can_be_set_and_checked_with_strings()
    {
        $user = factory('App\Model\Account')->create();

        $user->setRole('developer');

        $this->assertTrue($user->hasRole('developer'));
    }

    /**
    * @test
    */
    public function only_developers_can_modify_modules()
    {
        $this->signIn();

        $this->get('/admin/products/index')->assertDontSee('install');

        $this->get('/admin/products/install/articles')->assertRedirect('/admin');

        account()->setRole('developer');

        $this->get('/admin/products/index')->assertSee('install');

        $this->get('/admin/products/install/articles')->assertRedirect('/admin/products/index');
    }
}
