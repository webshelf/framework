<?php

namespace App\Modules;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleServiceProvider.
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ModuleManager::class, function () {
            return new ModuleManager(app(ModuleRepository::class));
        });
    }

    /**
     * Register the route mapping of the modules.
     *
     * @return void.
     */
    public static function map()
    {
        foreach (config('modules') as $key => $module) {
            $namespace = sprintf('App\Modules\%s', $module['title']);

            if (config("modules.{$key}.enabled")) {
                $backendRoute = base_path(sprintf('app/Modules/%s/Routes/backend.php', $module['title']));
                if (file_exists($backendRoute)) {
                    Route::middleware(['web', 'auth', 'gateway'])->namespace($namespace)->group($backendRoute);
                }

                $frontendRoute = base_path(sprintf('app/Modules/%s/Routes/frontend.php', $module['title']));
                if (file_exists($frontendRoute)) {
                    Route::middleware(['web'])->namespace($namespace)->group($frontendRoute);
                }
            }
        }
    }
}
