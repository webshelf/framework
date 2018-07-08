<?php

namespace Tests\Module;

use Exception;
use App\Model\Page;
use Tests\TestCase;
use App\Modules\ModuleManager;
use App\Modules\ModuleRepository;
use Illuminate\Support\Facades\Config;
use App\Modules\Pages\Model\PageOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ModuleManagerTest.
 */
class ModuleManagerTest extends TestCase
{
    /*
     * Database Traits
     */
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_will_throw_exception_if_config_does_not_exist()
    {
        // expects exception
        $this->expectException(ModuleNotFoundException::class);

        // when
        app(ModuleManager::class)->enable('unknown');
    }

    /**
     * @test
     * @throws ModuleNotFoundException
     */
    public function it_can_disable_a_module()
    {
        Config::set('modules.config', ['enabled' => true]);

        $module = $this->mockModuleManager();

        $module->disable('config');

        $this->assertFalse($module->status('config'));
    }

    /**
     * @test
     * @throws ModuleNotFoundException
     */
    public function it_can_enable_a_module()
    {
        Config::set('modules.config', ['enabled' => false]);

        $module = $this->mockModuleManager();

        $module->enable('config');

        $this->assertTrue($module->status('config'));
    }

    /**
     * @test
     * @throws ModuleNotFoundException
     */
    public function it_can_toggle_a_module()
    {
        Config::set('modules.config', ['enabled' => false]);

        $module = $this->mockModuleManager();

        $module->toggle('config');

        $this->assertTrue($module->status('config'));

        $module->toggle('config');

        $this->assertFalse($module->status('config'));
    }

    /**
     * @test
     * @throws ModuleNotFoundException
     */
    public function it_can_enable_pages_attached_to_module()
    {
        /** @var Page $page */
        $page = factory('App\Model\Page')->create(['module' => 'pictures', 'option' => PageOptions::OPTION_DISABLED]);

        Config::set('modules.pictures', ['title' => 'Pictures', 'enabled' => false]);

        $module = $this->mockModuleManager();

        $module->enable('pictures');

        $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_DEFAULT]);

        $this->assertTrue($module->status('pictures'));
    }

    /**
     * @test
     *
     * @throws \App\Modules\ModuleNotFoundException
     */
    public function it_can_disable_pages_attached_to_module()
    {
        /** @var Page $page */
        $page = factory('App\Model\Page')->create(['module' => 'pictures', 'option' => PageOptions::OPTION_PUBLIC]);

        Config::set('modules.pictures', ['title' => 'Pictures', 'enabled' => true]);

        $module = $this->mockModuleManager();

        $module->disable('pictures');

        $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_PUBLIC | PageOptions::OPTION_DISABLED]);

        $this->assertFalse($module->status('pictures'));
    }

    /**
     * @test
     * @throws ModuleNotFoundException
     */
    public function it_can_enable_multiple_pages_attached_to_module()
    {
        /** @var Page $page */
        $pages = factory('App\Model\Page', 4)->create(['module' => 'unit-testing', 'option' => PageOptions::OPTION_DISABLED]);

        Config::set('modules.unit-testing', ['title' => 'Unit Testing', 'enabled' => false]);

        $module = $this->mockModuleManager();

        $module->enable('unit-testing');

        foreach ($pages as $page) {
            $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_DEFAULT]);
        }

        $this->assertTrue($module->status('unit-testing'));
    }

    /**
     * @test
     * @throws ModuleNotFoundException
     */
    public function it_can_disable_multiple_pages_attached_to_module()
    {
        /** @var Page $page */
        $pages = factory('App\Model\Page', 4)->create(['module' => 'unit-testing', 'option' => PageOptions::OPTION_DEFAULT]);

        Config::set('modules.unit-testing', ['title' => 'Unit Testing', 'enabled' => true]);

        $module = $this->mockModuleManager();

        $module->disable('unit-testing');

        foreach ($pages as $page) {
            $this->assertDatabaseHas('pages', ['id' => $page->id, 'option' => PageOptions::OPTION_DISABLED]);
        }

        $this->assertFalse($module->status('unit-testing'));
    }

    /**
     * @test
     */
    public function it_can_return_all_modules_currently_enabled()
    {
        $this->mockConfiguration([
            'foo' => ['title' => 'foo', 'enabled' => true],
            'bar' => ['title' => 'bar', 'enabled' => true],
            'zor' => ['title' => 'zor', 'enabled' => false],
        ]);

        $modules = $this->mockModuleManager();

        $this->assertCount(2, $modules->getActive());
    }

    /**
     * @test
     */
    public function it_can_return_all_modules_currently_disabled()
    {
        $this->mockConfiguration([
            'san' => ['title' => 'foo', 'enabled' => false],
            'zap' => ['title' => 'bar', 'enabled' => true],
            'lae' => ['title' => 'zor', 'enabled' => false],
        ]);

        $modules = $this->mockModuleManager();

        $this->assertCount(2, $modules->getInactive());
    }

    /**
     * Mock the configuration file data.
     *
     * @param $array
     */
    private function mockConfiguration($array)
    {
        return config()->set('modules', $array);
    }

    /**
     * Mock the module repository on its own.
     *
     * @return \PHPUnit\Framework\MockObject\MockBuilder
     */
    private function mockModuleRepository()
    {
        return $this->getMockBuilder(ModuleRepository::class)->enableOriginalConstructor();
    }

    /**
     * Mock the module manager.
     *
     * @return ModuleManager
     */
    private function mockModuleManager()
    {
        // mock everything
        $mockedClass = $this->mockModuleRepository()->setMethodsExcept(['set', 'get', 'all'])->getMock();

        // save method will return
        $mockedClass->method('save')->willReturn(true);

        /* @var ModuleRepository $mockedClass */
        return new ModuleManager($mockedClass);
    }
}
