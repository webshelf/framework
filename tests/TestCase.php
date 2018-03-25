<?php

namespace Tests;

use Mockery;
use Faker\Factory;
use App\Model\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function visit(string $url, int $status = null, string $redirect = null)
    {
        if ($status) {
            if ($status == 302) {
                return $this->call('GET', $url)->assertStatus($status)->assertSee($redirect);
            } else {
                return $this->call('GET', $url)->assertStatus($status);
            }
        }

        return $this->call('GET', $url);
    }

    /**
     * Test dashboard access urls.
     *
     * Unauthenticated users should be redirected to login.
     * Authenticated users should be allowed to view the page.
     *
     * @param string $url
     */
    protected function dashboardAccessTest(string $url)
    {
        $this->call('GET', $url)->assertStatus(302)->assertSee('/admin/login');

        auth()->login(factory(Account::class)->make());

        $this->call('GET', $url)->assertStatus(200);
    }

    /**
     * Login using the test account on the database.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function login()
    {
        return auth()->login(factory(Account::class)->create());
    }

    /**
     * Mock a repository object.
     *
     * @param string $class
     * @param string $method
     * @param array|Collection $data
     * @return Mockery\Expectation
     */
    protected function mockRepository(string $class, string $method, Collection $data)
    {
        $mocker = Mockery::mock($class);

        $this->app->instance($class, $mocker);

        return $mocker->shouldReceive($method)->andReturn($data);
    }

    /**
     * Create a mocked object and return it from the container.
     *
     * @param string $class
     * @return Mockery\MockInterface
     */
    protected function mock(string $class)
    {
        $mockedClass = Mockery::mock($class);

        $this->app->instance($class, $mockedClass);

        return $mockedClass;
    }
}
