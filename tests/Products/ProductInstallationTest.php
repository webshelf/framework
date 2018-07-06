<?php

namespace Tests\Products;

use Mockery;
use Tests\TestCase;
use App\Modules\ModuleManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductInstallationTest extends TestCase
{
    /*
     * Database traits.
     */
    use RefreshDatabase, WithoutMiddleware;

    /**
     * @test
     */
    public function modules_can_be_toggled()
    {
        $mocked = Mockery::mock(ModuleManager::class)->shouldReceive('toggle')->andReturn(true)->getMock();

        $this->app->instance(ModuleManager::class, $mocked);

        $response = $this->get('/admin/products/test/toggle');

        $response->assertRedirect('/admin/products')->assertSee('test');
    }
}
