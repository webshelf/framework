<?php
/**
 * Created by PhpStorm.
 * User: Marky
 * Date: 10/12/2016
 * Time: 22:45
 */

namespace Tests\Unit;

use Tests\TestCase;
use App\Model\Setting;
use App\Classes\SettingsManager;

/**
 * Application testing of storage of settings.
 *
 * Class SettingsTest
 */
class SettingsTest extends TestCase
{
    /**
     * @var SettingsManager
     */
    public $settings;

    protected function setUp()
    {
        $this->settings = new SettingsManager;
    }

    public function test_settings_can_be_added()
    {
        $this->settings->add('PHPUnit Test', true);

        $this->assertEquals(true, $this->settings->getValue('PHPUnit Test'));
    }

    public function test_settings_can_be_modified()
    {
        $this->settings->add('PHPUnit Test', true);

        $this->settings->set('PHPUnit Test', false);

        $this->assertEquals(false, $this->settings->getValue('PHPUnit Test'));
    }

    public function test_settings_can_be_removed()
    {
        $this->settings->add('PHPUnit Test', true);

        $this->settings->remove('PHPUnit Test');

        $this->assertFalse($this->settings->has('PHPUnit Test'));
    }

    public function test_settings_can_return_its_shadow_value()
    {
        $this->settings->add('PHPUnit Test', 'default', 'shadow');

        $this->assertEquals('shadow', $this->settings->getShadow('PHPUnit Test'));
    }

    public function test_settings_can_return_a_default_key()
    {
        $this->settings->add('Default', 'Default',  null);
        $this->settings->add('Shadow',   null,     'Shadow');
        $this->settings->add('Value',   'Default', 'Shadow');

        $this->assertEquals('Default', $this->settings->getDefault('Default'));
        $this->assertEquals('Shadow',  $this->settings->getDefault('Shadow'));
        $this->assertEquals('Default', $this->settings->getDefault('Value'));
    }

    public function test_settings_can_add_a_collection_of_model_settings()
    {
        $collection = collect([
            'alpa'    => (new Setting)->setKey('alpa')->setValue('Some value')->setShadow('Some other value'),
            'bravo'   => (new Setting)->setKey('bravo')->setValue('Some value')->setShadow('Some other value'),
            'charlie' => (new Setting)->setKey('charlie')->setValue('Some value')->setShadow('Some other value'),
            'delta'   => (new Setting)->setKey('delta')->setValue('Some value')->setShadow('Some other value'),
            'echo'    => (new Setting)->setKey('echo')->setValue('Some value')->setShadow('Some other value'),
        ]);

        $this->settings->collect($collection);

        $this->assertEquals(5, $this->settings->count());
    }

}
