<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function visit(string $url, int $status = null, string $redirect = null)
    {
        if($status)
            if($status == 302)
                return $this->call('GET', $url)->assertStatus($status)->assertSee($redirect);
            else
                return $this->call('GET', $url)->assertStatus($status);

        return $this->call('GET', $url);
    }

    /**
     * Test dashboard access urls.
     *
     * Unauthenticated users should be redirected to login.
     * Authenticated users should be allowed to view the page.
     *
     */
    protected function dashboardAccessTest(string $url)
    {
        $this->call('GET', $url)->assertStatus(302)->assertSee('/admin/login');

        auth()->loginUsingId(1);

        $this->call('GET', $url)->assertStatus(200);
    }

    /**
     * Login using the test account on the database.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function login()
    {
        return auth()->loginUsingId(1);
    }
}
