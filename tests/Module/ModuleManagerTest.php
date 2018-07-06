<?php

namespace Tests\Module;

use App\Model\Page;
use App\Plugins\Pages\Model\PageOptions;
use Exception;
use App\Modules\ModuleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use App\Modules\ModuleManager;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

/**
 * Class ModuleManagerTest
 *
 * @package Tests\Module
 */
class ModuleManagerTest extends TestCase
{
    /**
     * Test traits.
     */
    use WithoutMiddleware, RefreshDatabase;

    /**
     * Mockery
     */
    use MockeryPHPUnitIntegration;

    /**
     * @test
     */
    public function a_module_will_error_if_plugin_is_not_found()
    {
        $this->expectException(Exception::class);

        app(ModuleManager::class)->enable('unknown');
    }

    /**
     * @test
     */
    public function a_module_can_be_disabled_using_configuration_file()
    {
        Config::set('modules.config', ['enabled' => true]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->disable('config');

        $this->assertFalse(app(ModuleManager::class)->status('config'));
    }

    /**
     * @test
     */
    public function a_module_can_be_enabled_using_configuration_file()
    {
        Config::set('modules.config', ['enabled' => false]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->enable('config');

        $this->assertTrue(app(ModuleManager::class)->status('config'));
    }

    /**
     * @test
     */
    public function a_module_can_be_toggled_using_configuration_file()
    {
        Config::set('modules.config', ['enabled' => false]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->toggle('config');

        $this->assertTrue(app(ModuleManager::class)->status('config'));

        app(ModuleManager::class)->toggle('config');

        $this->assertFalse(app(ModuleManager::class)->status('config'));
    }

    /**
     * @test
     */
    public function a_module_will_enable_pages_attached_to_module()
    {
        /** @var Page $page */
        $page = factory('App\Model\Page')->create(['module' => 'pictures', 'option' => PageOptions::OPTION_DISABLED]);

        Config::set('modules.pictures', ['title' => 'Pictures', 'enabled' => false]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->enable('pictures');

        $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_DEFAULT]);

        $this->assertTrue(app(ModuleManager::class)->status('pictures'));
    }

    /**
     * @test
     */
    public function a_module_will_disable_pages_attached_to_module()
    {
        /** @var Page $page */
        $page = factory('App\Model\Page')->create(['module' => 'pictures', 'option' => PageOptions::OPTION_PUBLIC]);

        Config::set('modules.pictures', ['title' => 'Pictures', 'enabled' => true]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->disable('pictures');

        $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_PUBLIC | PageOptions::OPTION_DISABLED]);

        $this->assertFalse(app(ModuleManager::class)->status('pictures'));
    }

    /**
     * @test
     */
    public function a_module_will_enable_multiple_pages_attached_to_module(){
        /** @var Page $page */
        $pages = factory('App\Model\Page', 4)->create(['module' => 'unit-testing', 'option' => PageOptions::OPTION_DISABLED]);

        Config::set('modules.unit-testing', ['title' => 'Unit Testing', 'enabled' => false]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->enable('unit-testing');

        foreach($pages as $page) {
            $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_DEFAULT]);
        }

        $this->assertTrue(app(ModuleManager::class)->status('unit-testing'));
    }

    /**
     * @test
     */
    public function a_module_will_disable_multiple_pages_attached_to_module(){
        /** @var Page $page */
        $pages = factory('App\Model\Page', 4)->create(['module' => 'unit-testing', 'option' => PageOptions::OPTION_DEFAULT]);

        Config::set('modules.unit-testing', ['title' => 'Unit Testing', 'enabled' => true]);

        $this->willSaveToConfigurationFile();

        app(ModuleManager::class)->disable('unit-testing');

        foreach($pages as $page) {
            $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_DISABLED]);
        }

        $this->assertFalse(app(ModuleManager::class)->status('unit-testing'));
    }


    /**
     * Mock the instance of saving to a configuration file.
     */
    private function willSaveToConfigurationFile(): void
    {
        $mock = $this->getMockBuilder(ModuleRepository::class)
            ->enableOriginalConstructor()
            ->setMethodsExcept(['set', 'get'])
            ->getMock();

        $mock->method('save')->willReturn(true);

        $this->app->instance(ModuleRepository::class, $mock);
    }
}
