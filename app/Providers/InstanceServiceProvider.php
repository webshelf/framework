<?php

namespace App\Providers;

use Exception;
use App\Classes\PluginManager;
use App\Classes\SettingsManager;
use Illuminate\Foundation\Application;
use App\Exceptions\EngineBootException;
use Illuminate\Support\ServiceProvider;
use App\Classes\Repositories\PluginRepository;
use App\Classes\Repositories\SettingsRepository;

/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 01/02/2017
 * Time: 10:05.
 */
class InstanceServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * Bootstrap application.
     * @return void
     */
    public function boot()
    {
        $this->makeSettingsInstance();

        $this->makePluginInstance();
    }

    private function makeSettingsInstance()
    {
        $this->app->singleton(SettingsManager::class, function () {
            try {
                return (new SettingsManager)->collect(app(SettingsRepository::class)->all());
            } catch (Exception $e) {
                if ($this->app->runningInConsole()) {
                    return new SettingsManager;
                }

                throw new EngineBootException('Could not perform query on the `settings database`, do we have proper connection settings?');
            }
        });
    }

    private function makePluginInstance()
    {
        $this->app->singleton(PluginManager::class, function () {
            try {
                return (new PluginManager)->collect(app(PluginRepository::class)->all());
            } catch (Exception $e) {
                if ($this->app->runningInConsole()) {
                    return new PluginManager;
                }

                throw new EngineBootException('Could not perform query on the `plugins database`, do we have proper connection settings?');
            }
        });
    }
}
