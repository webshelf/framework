<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Class ConfigTest.
 */
class ConfigProviderTest extends TestCase
{
    // Database traits.
    use RefreshDatabase, WithoutMiddleware;

    /**
     * @test
     */
    public function the_configuration_should_match_the_database_configuration()
    {
        $this->assertEquals('Your CMS', config('app.name'));
    }
}
