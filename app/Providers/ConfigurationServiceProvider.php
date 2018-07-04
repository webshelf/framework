<?php

namespace App\Providers;

use \Schema;
use App\Model\Configuration;
use Illuminate\Support\ServiceProvider;

/**
 * Bootstrap for System Configuration.
 */
class ConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap System Configuration to Laravel Configuration.
     *
     * The configuration can be loaded from the database allowing the user
     * to overwrite the default framework configuration values such as name
     * etc, this also allows us to use the fluent laravel configuration service.
     *
     * @return void Will default to original laravel configuration if we are testing
     */
    public function boot()
    {
        if (!app()->configurationIsCached() && Schema::hasTable('system_config')) {
            foreach (Configuration::all() as $key => $configuration) {
                $this->app->make('config')->set($configuration->key, $configuration->value);
            }
        }
    }
}
