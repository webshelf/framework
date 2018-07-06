<?php

namespace Tests\Products;

use App\Modules\ModuleManager;
use Illuminate\Support\Facades\Config;
use \Mockery;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Event;
use Larapack\ConfigWriter\Repository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductInstallationTest extends TestCase
{
    /**
     * Database traits.
     */
    use RefreshDatabase, WithoutMiddleware;

    /**
     * @test
     */
    public function modules_can_be_enabled()
    {
        Mockery::mock(ModuleManager::class)->shouldReceive('enable')->andReturn(true);

        Config::set('modules.test', ['enabled' => false]);

        $response = $this->get('/admin/products/test/toggle');

        $response->assertRedirect('/admin/products')->assertSee('test');
    }

}
