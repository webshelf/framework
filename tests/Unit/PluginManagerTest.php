<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Model\Plugin;
use App\Classes\PluginManager;

class PluginManagerTest extends TestCase
{
    /**
     * @var Plugin
     */
    public $plugin;

    /**
     * @var PluginManager
     */
    public $plugins;

    /**
     * @var PluginManager
     */
    protected function setUp()
    {
        $this->plugin = new Plugin;

        $this->plugins = new PluginManager;
    }

    /**
     * @test
     */
    public function plugins_can_be_created()
    {
        $this->plugins->add($this->plugin->setName('plugin')->setEnabled(true));

        $this->assertTrue($this->plugins->hasPlugin('plugin'));
        $this->assertTrue($this->plugins->enabled('plugin'));
    }

    /**
     * @test
     */
    public function plugins_available_can_be_returned()
    {
        $this->plugins->add($this->plugin->setName('plugin-one')->setEnabled(true));
        $this->plugins->add($this->plugin->setName('plugin-two')->setEnabled(false));

        $this->assertCount(2, $this->plugins->all());
    }

    /**
     * @test
     */
    public function plugins_are_able_to_have_their_status_checked()
    {
        $this->plugins->add($this->plugin->setName('plugin1')->setEnabled(true));

        $this->assertTrue($this->plugins->enabled('plugin1'));

        $this->plugins->add($this->plugin->setName('plugin2')->setEnabled(false));

        $this->assertTrue($this->plugins->disabled('plugin2'));

        $this->assertCount(1, $this->plugins->disabled());

        $this->assertCount(1, $this->plugins->enabled());
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Cannot load the plugin (expect_exception) as it does not exist.
     */
    public function check_call_to_nonexisting_plugin_returns_exception()
    {
        $this->plugins->enabled('expect_exception');
    }
}
