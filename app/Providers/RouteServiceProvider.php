<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\Routing\Router;

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

        //
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
     * @return void
     */
    protected function mapPluginRoutes()
    {
        Route::middleware('web')->group(base_path('routes/plugin.php'));
    }

    /**
     * Define the backend routes for the application.0

     * Modules are loaded as modularity.
     *
     * @return void
     */
    protected function mapModulesRoutes()
    {
        foreach(config('modules') as $module)
        {
            $namespace = sprintf('App\Modules\%s', $module['title']);

            $backendRoute = base_path(sprintf('app/modules/%s/routes/backend.php', $module['title']));

            $frontendRoute = base_path(sprintf('app/modules/%s/routes/frontend.php', $module['title']));

            // Frontend are routes that can be accessed by visitors.
            Route::middleware('web')->namespace($namespace)->group($frontendRoute);

            // Backend are routes that can only be accessed to those with access.
            Route::middleware('web', 'auth')->namespace($namespace)->group($backendRoute);
        }
    }
}
