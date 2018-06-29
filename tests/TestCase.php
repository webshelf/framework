<?php

namespace Tests;

use Mockery;
use Faker\Factory;
use App\Model\Account;
use App\Exceptions\Handler;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->disableExceptionHandling();
    }

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

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }

    // Hat tip, @adamwathan.
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(\Exception $e)
            {
            }

            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }

    /**
     * Login using the test account on the database.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function signIn($properties = [])
    {
        auth()->login(factory('App\Model\Account')->create($properties));

        return $this;
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
