<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Model\Plugin;
use App\Classes\Roles\Developer;
use App\Plugins\Articles\ArticlesController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PluginInstallationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function the_article_plugin_exists_in_the_database()
    {
        $plugin = Plugin::whereName('articles')->first();

        $this->assertEquals('articles', $plugin['name']);
    }

    /**
     * @test
     */
    public function the_article_plugin_can_be_toggled()
    {
        $plugin = Plugin::whereName('articles')->first();

        $plugin->toggle();

        $this->assertTrue($plugin->enabled);
    }

    /**
     * @test
     */
    public function the_article_plugin_has_a_controller_class()
    {
        $plugin = Plugin::whereName('articles')->first();

        $this->assertInstanceOf(ArticlesController::class, $plugin->controller);
    }

    /**
     * @test
     */
    public function the_article_plugin_exists_on_the_dashboard()
    {
        $this->signIn(['role_id' => Developer::$key]);

        $this->get('admin/products/index')
            ->assertSee('Articles');
    }

    /**
     * @test
     */
    public function the_article_plugin_can_be_installed()
    {
        $this->signIn(['role_id' => Developer::$key]);

        $this->get('/admin/products/install/articles')
            ->assertRedirect('/admin/products/index');

        $this->assertDatabaseHas('plugins', ['name'       => 'articles', 'enabled' => true]);
        $this->assertDatabaseHas('pages', ['identifier' => 'articles']);
    }

    /**
     * @test
     */
    public function the_article_plugin_can_be_uninstalled()
    {
        $this->signIn(['role_id' => Developer::$key]);

        $this->get('/admin/products/install/articles');

        $this->get('/admin/products/uninstall/articles')
            ->assertRedirect('/admin/products/index');

        $this->assertDatabaseHas('plugins', ['name' => 'articles', 'enabled' => false]);
        $this->assertDatabaseMissing('pages', ['identifier' => 'articles']);
    }
}
