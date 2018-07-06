<?php

namespace Tests\Products;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDashboardTest extends TestCase
{
    /**
     * Database traits.
     */
    use RefreshDatabase, WithoutMiddleware;

    /**
     * @test
     */
    public function the_modules_are_viewable_on_the_products_index()
    {
        $this->signIn();

        $response = $this->get('admin/products');

        foreach (config('modules') as $module) {
            $response->assertSee($module['title']);
        }

        $response->assertOk();
    }

}
