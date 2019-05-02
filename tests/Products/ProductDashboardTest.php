<?php

namespace Tests\Products;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductDashboardTest extends TestCase
{
    /*
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

        $response->assertStatus(200);
    }
}
