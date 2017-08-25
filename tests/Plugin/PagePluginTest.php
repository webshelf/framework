<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 24/08/2017
 * Time: 16:40.
 */

namespace Tests\Plugin;

use Tests\TestCase;

class PagePluginTest extends TestCase
{
    /**
     * @test
     */
    public function index_should_return_all_available_pages()
    {
        $this->login();

        $response = $this->call('GET', '/admin/pages');

        dd($response->isSuccessful());
    }
}
