<?php

namespace App\Providers;

use App\Model\Plugin;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapPluginRoutes();

        $this->mapModulesRoutes();

        $this->mapVendorRoutes();

        \Log::useFiles('php://stderr');

        //  dd((app(\Illuminate\Routing\Router::class))->getRoutes());
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }

    /**
     * Define the backend routes for the application.
     *
     * Plugins have dynamic creation of web vs admin.
     *
     * "
     * @return void
     */
    protected function mapPluginRoutes()
    {
        /** @var Plugin $plugin */
        foreach (plugins()->getEnabled() as $plugin) {
            $plugin_name = ucfirst($plugin->name());

            $namespace = sprintf('App\Plugins\%s', $plugin_name);

            $backendRoute = base_path(sprintf('app/Plugins/%s/Routes/backend.php', $plugin_name));

            $frontendRoute = base_path(sprintf('app/Plugins/%s/Routes/frontend.php', $plugin_name));

            Route::middleware(['web'])->group($frontendRoute);

            Route::middleware(['web', 'auth'])->namespace($namespace)->group($backendRoute);
        }
    }

    /**
     * Define the backend routes for the application.0.
     *
     * Modules are loaded as modularity.
     *
     * @return void
     */
    protected function mapModulesRoutes()
    {
        foreach (config('modules') as $module) {
            $module_name = ucfirst($module['title']);

            $namespace = sprintf('App\Modules\%s', $module['title']);

            $backendRoute = base_path(sprintf('app/Modules/%s/Routes/backend.php', $module_name));

            $frontendRoute = base_path(sprintf('app/Modules/%s/Routes/frontend.php', $module_name));

            // Frontend are routes that can be accessed by visitors.
            Route::middleware(['web'])->group($frontendRoute);

            // Backend are routes that can only be accessed to those with access.
            Route::middleware(['web', 'auth'])->namespace($namespace)->group($backendRoute);
        }
    }

    /**
     * Third party routes sometimes require auth, and sometimes not, but since we dont
     * define a namespace, its best have it in its seperate folder for simplicity.
     */
    protected function mapVendorRoutes()
    {
        Route::middleware('web')->group(base_path('routes/vendor.php'));
    }
}
