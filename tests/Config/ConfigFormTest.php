<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Class ConfigTest
 *
 * @package Tests\Feature
 */
class ConfigFormTest extends TestCase
{
    // Database traits.
    use RefreshDatabase, WithoutMiddleware;

    /**
     * @test
     */
    public function settings_module_can_save_a_value()
    {
        factory('App\Model\Configuration')->create(['key' => 'unit.name']);

        $this->post('/admin/settings/update', ['setting'=> ['unit.name' => 'PHP Unit Test']]);

        $this->assertDatabaseHas('system_config', ['key' => 'unit.name', 'value' => 'PHP Unit Test']);
    }

    /**
     * @test
     */
    public function settings_module_can_save_multiple_values()
    {
        factory('App\Model\Configuration')->create(['key' => 'unit.one']);
        factory('App\Model\Configuration')->create(['key' => 'unit.two']);

        $this->post('/admin/settings/update', ['setting'=> ['unit.one' => true, 'unit.two' => false]]);

        $this->assertDatabaseHas('system_config', ['key' => 'unit.one', 'value' => true]);
        $this->assertDatabaseHas('system_config', ['key' => 'unit.two', 'value' => false]);
    }

    /**
     * @test
     */
    public function settings_module_can_save_multiple_values_including_nulls()
    {
        factory('App\Model\Configuration')->create(['key' => 'unit.one']);
        factory('App\Model\Configuration')->create(['key' => 'unit.two']);
        factory('App\Model\Configuration')->create(['key' => 'unit.three']);

        $this->post('/admin/settings/update', ['setting'=> ['unit.one' => true, 'unit.two' => false, 'unit.three' => null]]);

        $this->assertDatabaseHas('system_config', ['key' => 'unit.one', 'value' => true]);
        $this->assertDatabaseHas('system_config', ['key' => 'unit.two', 'value' => false]);
        $this->assertDatabaseHas('system_config', ['key' => 'unit.three', 'value' => null]);
    }
}
